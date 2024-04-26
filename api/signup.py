import requests
from flask import request, jsonify, session

from service.JwtToken import generate_jwt
from service.UserService import get_user_by_phone, create_user


def signup():
    try:
        number = request.form.get('mobile')
        secret = request.form.get('secret')
        otp = request.form.get('otp')
        password = request.form.get('pass')

        if not number or not otp:
            return jsonify({'success': False, 'error': 'Number and otp are required parameters'}), 400

        entered_code = int(otp)
        api_url = "https://2factor.in/API/V1/d7b643bb-d6aa-11eb-8089-0200cd936042/SMS/VERIFY/{}/{}"
        api_url = api_url.format(secret, entered_code)
        response = requests.get(api_url, headers={'Content-Type': 'application/json'})
        response_data = response.json()

        if response_data.get('Status') == "Success":
            user_details = create_user(number, password)

            session['phone'] = number
            session['user_id'] = user_details.id
            session.permanent = True
            token = generate_jwt({'user_id': user_details.id, 'is_admin': user_details.is_admin})

            return jsonify({'success': "1", 'msg': 'Verification successful', 'user_details': user_details, 'session': token}), 200
        else:
            return jsonify({'success': False, 'msg': 'Invalid Otp'}), 400

    except Exception as e:
        print('Error verifying code:', e)
        return jsonify({'success': False, 'msg': 'Error verifying code'}), 500


def signup2():
    try:
        number = request.form.get('mobile')
        password = request.form.get('pass')

        if not number or not password:
            return jsonify({'success': False, 'error': 'Number and password are required parameters'}), 400

        user_details = create_user(number, password)

        session['phone'] = number
        session['user_id'] = user_details.id
        session.permanent = True
        return jsonify({'success': "1", 'message': 'Verification successful'}), 200

    except Exception as e:
        print('Error verifying code:', e)
        return jsonify({'success': False, 'error': 'Error verifying code'}), 500


def logout():
    session.pop('phone', None)
    session.pop('user_id', None)
    return jsonify({'success': "1", 'message': 'Logged out successfully'}), 200
