from flask import request, jsonify
import requests
from app import app


@app.route('/send_otp', methods=['POST'])
def send_otp():
    try:
        data = request.json
        number = data.get('phone')

        if not number:
            return jsonify({'success': False, 'error': 'phone number is null'}), 400

        api_url = 'https://2factor.in/API/V1/d7b643bb-d6aa-11eb-8089-0200cd936042/SMS/{}/AUTOGEN/EpicWin'
        api_url = api_url.format('+91' + number)

        response = requests.get(api_url, headers={'Content-Type': 'application/json'})
        response_data = response.json()
        print(response)

        if response_data.get('Status') == "Success":
            return jsonify(
                {'success': True, 'secret': response_data['Details'], 'message': 'Otp code sent successfully'}), 200
        else:
            return jsonify({'success': False, 'error': 'Error sending Otp Code.'}), 500

    except Exception as e:
        print('Error sending verification code:', e)
        return jsonify({'success': False, 'error': 'Error sending otp code'}), 500
