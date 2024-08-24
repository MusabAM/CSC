import requests
import threading
import time

url = "http://localhost/Task_tracker/sigin.html"
def make_request(name):
    while True:
        try:
            r = requests.get(url)
        except:
            pass
        time.sleep(0.01)  

threads = 1024 
i = 0

while i < threads:
    x = threading.Thread(target=make_request, args=(i,))
    print(f"Starting thread #{i}.....")
    x.start()
    i += 1


