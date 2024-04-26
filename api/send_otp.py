from flask import request, jsonify
import requests


def send_otp():
    try:
        number = request.form.get('mobile')
        otp = request.form.get('otp')

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


def send_otp2():
    try:
        number = request.form.get('mobile')
        otp = request.form.get('otp')

        if not number:
            return jsonify({'success': False, 'msg': 'phone number is null'}), 400

        message = "Verify+Mobile,+No.+Your+OTP+is+{}+To+Login+in+App+ARNAV".format(otp)

        url = "http://sms.smslab.in/api/sendhttp.php"
        params = {
            "authkey": "393055AeJCj8aMhr836419c96fP1",
            "mobiles": "91" + number,
            "message": message,
            "sender": "ARVIPT",
            "route": 4,
            "country": 91,
            "DLT_TE_ID": "1307167958154244221"
        }

        response = requests.get(url, params=params)
        if response.status_code == 200:
            return jsonify({'success': "1"}), 200
        else:
            return jsonify({'success': "0", 'msg': 'Error sending Otp Code.'}), 500

    except Exception as e:
        print('Error sending verification code:', e)
        return jsonify({'success': "0", 'msg': 'Error sending otp code'}), 500
