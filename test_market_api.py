import requests


def test_add_market():
    url = "http://127.0.0.1:5000/admin_add_market"
    data = {
        "name": "Test Market",
        "open_time": "10:30 AM",
        "close_time": "4:00 AM",
        "result_time": "10:30 PM"
    }
    response = requests.post(url, json=data)
    handle_response(response)

def test_view_market_details(market_id):
    url = f"http://127.0.0.1:5000/admin_view_market_details?market_id={market_id}"
    response = requests.get(url)
    handle_response(response)


def test_edit_market(market_id):
    url = "http://127.0.0.1:5000/admin_edit_market"
    data = {
        "market_id": market_id,
        "name": "Updated Market Name",
        "open_time": "05:00 AM",
        "close_time": "07:00 AM",
        "result_time": "01:00 PM"
    }
    response = requests.post(url, json=data)
    handle_response(response)


def test_delete_market(market_id):
    url = f"http://127.0.0.1:5000/admin_delete_market?market_id={market_id}"
    response = requests.post(url)
    handle_response(response)


def handle_response(response):
    if response.status_code == 200:
        print("Success:", response.json())
    else:
        print("Error:", response.text)


if __name__ == "__main__":
    # test_add_market()
    # test_view_market_details(2)  
    test_edit_market(6)          
    # test_delete_market(2)        


# import random
# from faker import Faker

# # Initialize Faker library
# fake = Faker('en_IN')

# # Generate and print 25 insert statements
# for _ in range(25):
#     phone = fake.phone_number()
#     email = fake.email()
#     name = fake.name()
#     password = ''.join(random.choices('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', k=6))
#     total_balance = random.randint(5000, 20000)
#     deposit_balance = random.randint(0, total_balance)
#     winning_balance = random.randint(0, total_balance - deposit_balance)
#     bonus_balance = total_balance - deposit_balance - winning_balance
#     pin = None
#     bank_ac_no = fake.random_number(digits=12)
#     bank_ac_name = name
#     bank_ifsc_code = fake.random_number(digits=6)
#     bank_name = fake.word()
#     active = 1
#     created_at = fake.date_time_this_year(before_now=True, after_now=False, tzinfo=None).strftime('%Y-%m-%d %H:%M:%S')

#     # Print the insert statement
#     print(f"INSERT INTO user (phone, email, name, password, total_balance, deposit_balance, winning_balance, bonus_balance, pin, bank_ac_no, bank_ac_name, bank_ifsc_code, bank_name, active, created_at) VALUES ({phone}, '{email}', '{name}', '{password}', {total_balance}, {deposit_balance}, {winning_balance}, {bonus_balance}, {pin}, '{bank_ac_no}', '{bank_ac_name}', '{bank_ifsc_code}', '{bank_name}', {active}, '{created_at}');")

