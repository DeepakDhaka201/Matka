import requests
from flask import request, jsonify, session

from service.UserService import get_user_by_phone


#@app.route('/user/login', methods=['POST'])
def login():
    try:
        data = request.json
        number = data.get('phone')
        secret = data.get('secret')
        otp = data.get('otp')

        if not number or not otp:
            return jsonify({'success': False, 'error': 'Number and otp are required parameters'}), 400

        entered_code = int(otp)
        api_url = "https://2factor.in/API/V1/d7b643bb-d6aa-11eb-8089-0200cd936042/SMS/VERIFY/{}/{}"
        api_url = api_url.format(secret, entered_code)
        response = requests.get(api_url, headers={'Content-Type': 'application/json'})
        response_data = response.json()

        if response_data.get('Status') == "Success":
            user_details = get_user_by_phone(number)

            session['phone'] = number
            session['user_id'] = user_details.id
            session.permanent = True
            return jsonify({'success': True, 'message': 'Verification successful', 'user_details' : user_details}), 200
        else:
            return jsonify({'success': False, 'error': 'Invalid Otp'}), 400

    except Exception as e:
        print('Error verifying code:', e)
        return jsonify({'success': False, 'error': 'Error verifying code'}), 500
