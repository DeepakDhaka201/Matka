from datetime import datetime

from api.wallet import update_referral_bonus
from extension import db
from models.Transaction import Transaction
from models.User import User


def update_transaction(transaction, status, remark, refund):
    try:
        with db.session.begin_nested():
            if transaction.type == Transaction.Type.DEPOSIT.name:
                if status == Transaction.Status.SUCCESS.name:
                    transaction.status = status
                    user = User.query.get(transaction.user_id)
                    user.total_balance += transaction.amount
                    user.deposit_balance += transaction.amount
                elif status == Transaction.Status.CANCELLED.name:
                    transaction.status = status
                    transaction.remark = remark if remark else transaction.remark
            elif transaction.type == Transaction.Type.WITHDRAWAL.name:
                if status == Transaction.Status.SUCCESS.name:
                    transaction.status = status
                elif status == Transaction.Status.CANCELLED.name:
                    transaction.status = status
                    transaction.remark = remark if remark else transaction.remark
                    if refund:
                        user = User.query.get(transaction.user_id)
                        user.total_balance += transaction.amount
                        user.winning_balance += transaction.amount
        db.session.commit()

        if transaction.type == Transaction.Type.DEPOSIT.name:
            if status == Transaction.Status.SUCCESS.name:
                user = User.query.get(transaction.user_id)
                update_referral_bonus(user, transaction.amount)

        return True
    except Exception as e:
        db.session.rollback()
        raise e;


def fetch_transactions(user_id, type, status, from_time, to_time):
    query = db.session.query(Transaction)
    if user_id:
        query = query.filter(Transaction.user_id == user_id)
    if type:
        query = query.filter(Transaction.type == type)
    if status:
        query = query.filter(Transaction.status == status)

    if from_time and to_time:
        from_time = datetime.strptime(from_time, "%d/%m/%Y")
        to_time = datetime.strptime(to_time, "%d/%m/%Y")
        query = query.filter(Transaction.created_at >= from_time).filter(Transaction.created_at <= to_time)
    else:
        query = query.filter(Transaction.created_at >= datetime.now().replace(hour=0, minute=0, second=0, microsecond=0))

    print(query)
    transactions = query.all()
    users = User.query.filter(User.id.in_([transaction.user_id for transaction in transactions])).all()
    user_map = {user.id: user for user in users}

    response = []
    for transaction in transactions:
        user = user_map.get(transaction.user_id)
        response.append({
            "id": transaction.id,
            "type": transaction.type,
            "sub_type": transaction.sub_type,
            "user_phone": user.phone,
            "user_name": user.name,
            "amount": transaction.amount,
            "mode": transaction.mode,
            "info": transaction.info,
            "status": transaction.status,
            "remark": transaction.remark,
            "created_at": transaction.created_at,
        })
    return response
