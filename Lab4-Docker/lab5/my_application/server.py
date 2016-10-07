from flask import Flask
app = Flask(__name__)

@app.route('/')
def index():
    return 'Index Page'

@app.route('/hello')
def hello():
    return 'Hello World'

@app.route('/user/paul')
def paul():
    return 'User paul'

@app.route('/post/80')
def post():
    return 'Post 800'

if __name__ == "__main__":
    app.run(host='0.0.0.0', debug=True)
