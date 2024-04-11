from flask import request, jsonify, session

from models.User import User
from service.UserService import get_user_by_phone, update_password, validate_session, update_user_profile


def login():
    try:
        number = request.form.get('mobile')
        password = request.form.get('pass')

        user_details = get_user_by_phone(number)
        if password == user_details.password:
            session['phone'] = number
            session['user_id'] = user_details.id
            session.permanent = True
            return jsonify({
                'success': "1",
                'mobile': number,
                'name': user_details.name if user_details.name else "User",
                'email': user_details.email,
                'session': '1',
            }), 200
        else:
            return jsonify({'success': False, 'error': 'Invalid password'}), 400

    except Exception as e:
        print('Error verifying code:', e)
        return jsonify({'success': False, 'error': 'Error verifying code'}), 500


def forgot_password():
    try:
        number = request.form.get('mobile')
        password = request.form.get('pass')

        if not number or not password:
            return jsonify({'success': False, 'error': 'Number and password are required parameters'}), 400

        #update_password(number, password)
        return jsonify({'success': "1", 'message': 'Verification successful'}), 200

    except Exception as e:
        print('Error verifying code:', e)
        return jsonify({'success': False, 'error': 'Error verifying code'}), 500


def update_user_password():
    user_id = validate_session()
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

#PHONE
#EMAIL
#NAME
def update_profile():
    user_id = validate_session()
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
