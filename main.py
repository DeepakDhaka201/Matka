import requests

otp = "333423"
mobile = "7073160557" #"9509251093"

message = "Verify+Mobile,+No.+Your+OTP+is+{}+To+Login+in+App+ARNAV".format(otp)

url = "http://sms.smslab.in/api/sendhttp.php"
params = {
    "authkey": "393055AeJCj8aMhr836419c96fP1",
    "mobiles": "91" + mobile,
    "message": message,
    "sender": "ARVIPT",
    "route": 4,
    "country": 91,
    "DLT_TE_ID": "1307167958154244221"
}

response = requests.get(url, params=params)
print(response.status_code)
