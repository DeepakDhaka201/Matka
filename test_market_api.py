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
    test_add_market()
    test_view_market_details(2)  
    test_edit_market(2)          
    test_delete_market(2)        
