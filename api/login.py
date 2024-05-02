from flask import request, jsonify, session

from models.AppUpdate import AppUpdate
from models.User import User
from service.JwtToken import generate_jwt
from service.UserService import get_user_by_phone, update_password, validate_session, update_user_profile


def get_config():
    update = AppUpdate.query.order_by(AppUpdate.version.desc()).first()
    if not update:
        latest_version = 0
        update_link = ""
        update_log = ""
    else:
        latest_version = update.version
        update_link = update.link
        update_log = update.log

    return jsonify({"success": "1", "latest_version": latest_version, "update_link": update_link,
                    "update_log": update_log})


def login():
    try:
        number = request.form.get('mobile')
        password = request.form.get('pass')

        print(number, password)

        user_details = get_user_by_phone(number)
        if password == user_details.password:
            session['phone'] = number
            session['user_id'] = user_details.id
            session['is_admin'] = user_details.is_admin
            session.permanent = True

            token = generate_jwt({'user_id': user_details.id, 'is_admin': user_details.is_admin})

            return jsonify({
                'success': "1",
                'mobile': number,
                'name': user_details.name if user_details.name else "User",
                'email': user_details.email,
                'session': token,
            }), 200
        else:
            return jsonify({'success': False, 'msg': 'Invalid password'}), 200

    except Exception as e:
        print('Error verifying code:', e)
        return jsonify({'success': False, 'msg': str(e)}), 200


def forgot_password():
    try:
        number = request.form.get('mobile')
        password = request.form.get('pass')

        if not number or not password:
            return jsonify({'success': False, 'msg': 'Number and password are required parameters'}),200

        update_password(number, password)
        return jsonify({'success': "1", 'msg': 'Verification successful'}), 200

    except Exception as e:
        print('Error verifying code:', e)
        return jsonify({'success': False, 'msg': 'Error verifying code'}), 200


def update_user_password():
    user_id, is_admin = validate_session()
    try:
        number = request.form.get('mobile')
        password = request.form.get('pass')

        if not number or not password:
            return jsonify({'success': False, 'error': 'Number and password are required parameters'}), 400

        user_details = User.query.get(user_id)
        if number != user_details.phone:
            return jsonify({'success': False, 'error': 'Invalid phone number'}), 400

        update_password(number, password)
        return jsonify({'success': "1", 'message': 'Verification successful'}), 200

    except Exception as e:
        print('Error verifying code:', e)
        return jsonify({'success': False, 'error': 'Error verifying code'}), 500


def update_profile():
    user_id, is_admin = validate_session()
    try:
        phone = request.form.get('mobile')
        email = request.form.get('email')
        name = request.form.get('name')

        if not phone:
            return jsonify({'success': False, 'error': 'Phone is required parameters'}), 400

        update_user_profile(user_id, phone, email, name)
        return jsonify({'success': "1", 'message': 'Profile updated successfully'}), 200

    except Exception as e:
        print('Error updating profile:', e)
        return jsonify({'success': False, 'error': 'Error updating profile'}), 500
