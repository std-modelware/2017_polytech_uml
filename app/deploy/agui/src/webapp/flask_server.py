from flask import Flask, render_template, request, flash, session, redirect, get_flashed_messages, url_for, jsonify
import json, requests

PICO_PORT = 8080
SECRET_KEY = b':Rq\xc6\xa3\xc00\xc0F\xce\xf1\xaa0\x14\xedb\x8b\t\xcbEuk\xbfp'

app = Flask(__name__)
app.secret_key = SECRET_KEY

@app.route('/')
def index(): 
	print(addStu())
	return render_template('index.html')

@app.route('/login/', methods=['GET', 'POST'])
def login(): 
	try:
		if request.method == 'POST':
			data = json.loads(request.data.decode("utf-8"))
			login_result = send_login(data['login'], data['password'])
			if login_result["status"]:
				flash("You sucessfully logged in")
				session['token'] = login_result["token"]
				return respond("Success", 200)
			else:
				flash("Fail: {}".format(login_result["msg"]))
				return respond("Fail: {}".format(login_result["msg"]), 500)
	except Exception as e:
		flash(e)
		return respond(e, 500)
	return render_template('login.html')

def respond(msg, code):
	resp = jsonify({
    'status_code': code,
    'msg': msg
    })
	resp.status_code = code
	return resp

def addStu():
	api_url = "http://localhost:{}/dean/admin/add_student".format(PICO_PORT)
	req = {'name': 'Boris','group_id':'1'}
	r = requests.post(url=api_url, json=req)
	print("got answer to login req. code: {}".format(r.status_code))
	return json.loads(r.text)

def send_login(login, password):
	api_url = "http://localhost:{}/login".format(PICO_PORT)
	req = {'login': login,'password':password}
	r = requests.post(url=api_url, json=req)
	print("got answer to login req. code: {}".format(r.status_code))
	return json.loads(r.text)

def check_token(url, token):
	api_url = "http://localhost:{}/check".format(PICO_PORT)
	req = {'url': url,'token':token}
	r = requests.post(url=api_url, json=req)
	print("got answer to check req. code: {}".format(r.status_code))
	return json.loads(r.text)

def login_required(function_to_protect):
	@wraps(function_to_protect)
	def wrapper(*args, **kwargs):
		token = session.get('token')
		if token:
			check_result = check_token("/", token)
			if check_result["status_code"] == 200:
				return function_to_protect(*args, **kwargs)
			else:
				flash(check_resultp.get("msg", "Forbidden"))
				return redirect(url_for('login'))
		else:
			flash("No session. Please login")
			return redirect(url_for('login'))

if __name__=='__main__': 
	app.run(debug=True, port=5090)