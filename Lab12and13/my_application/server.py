import boto
import boto.sqs
import boto.sqs.queue
from boto.sqs.message import Message
from boto.sqs.connection import SQSConnection
from boto.exception import SQSError
import sys
import urllib2
from flask import Flask, Response, render_template, request
import json
app = Flask(__name__)

response = urllib2.urlopen('http://ec2-52-30-7-5.eu-west-1.compute.amazonaws.com:81/key')
keys = response.read().split(':')

# Get the keys from a specific url and then use them to connect to AWS Service 
access_key_id = keys[0]
secret_access_key = keys[1]

# Set up a connection to the AWS service. 
conn = boto.sqs.connect_to_region("eu-west-1", aws_access_key_id=access_key_id, aws_secret_access_key=secret_access_key)

@app.route("/version")
def hello():
    return boto.Version

@app.route("/key")
def get_conn():
    keysReturn = keys[0] + ":" + keys[1]
    return keysReturn

@app.route('/queues', methods=['GET']) 
def queues_index():
    """
    List all queues
    curl -s -X GET -H 'Accept: application/json' http://localhost:5000/queues | python -mjson.tool
    """

    all = []

    for q in conn.get_all_queues():
        all.append(q.name)
    resp = json.dumps(all)
    return Response(response=resp, mimetype="application/json")

@app.route('/create', methods=['POST'])
def create_queues():
    """
    List all queues
    curl -s -X POST -H 'Content-Type:application/json' http://localhost:5000/create -d '{"name":"my-queue"}'
    """
    body = request.get_json(force=True)
    name = body['name']
    
    conn.create_queue(name)
    return 'queue ' + name + ' is now created'

@app.route('/queues/<name>', methods=['DELETE'])
def queues_remove(name):
    """
    Delete a specific queues
    curl -X DELETE -H 'Accept: application/json' http://localhost:5000/queues/<mytestqueue>
    """
    q = conn.get_queue(name)
    conn.delete_queue(q)
    return 'queue ' + name + ' is now deleted'
    
    

@app.route('/queues/<name>/msgs/count', methods=['GET'])
def queues_get_count(name):
    """
    curl -X GET -H 'Accept: application/json' http://localhost:5000/queues/<name>/msgs/count
    """
    q = conn.get_queue(name)
    resp = '{{"name":"%s"}, {"count":"%s"}}' % (name, str(q.count())) 
    return Response(response=resp, mimetype="application/json")


@app.route('/queues/<name>/msgs', methods=['POST'])
def write_message(name):
    """
    curl -s -X POST -H 'Accept:application/json' http://localhost:5000/queues/<mytestqueue>/msgs -d '{"content": "message"}'
    """
    body = request.get_json(force=True)
    message = body['content']
    q = conn.get_queue(name)
    m = Message()
    m.set_body(message)
    q.write(m)
    resp = '{{"name":"%s"}, {"message":"%s"}}' % (name, message) 
    return Response(response=resp, mimetype="application/json")

@app.route('/queues/<name>/msgs', methods=['GET'])
def read_message(name):
    """
    curl -X GET -H 'Accept: application/json' http://localhost:5000/queues/<name>/msgs
    """
    q = conn.get_queue(name)
    if(q.count() > 0):
        message = q.get_messages()
        resp = '{{"name":"%s"}, {"message":"%s"}}' % (name, message[0].get_body()) 
        return Response(response=resp, mimetype="application/json")
    return "No Messages"

@app.route('/queues/<name>/msgs', methods=['DELETE'])
def delete_message(name):
    """
    curl -X DELETE -H 'Accept: application/json' http://localhost:5000/queues/<name>/msgs
    """
    q = conn.get_queue(name)
    if(q.count() > 0):
        message = q.get_messages()
        resp = '{{"name":"%s"}, {"message":"%s"}, {"action":"DELETED"}}' % (name, message[0].get_body()) 
        q.delete_message(message[0])
        return Response(response=resp, mimetype="application/json")
        
    return "No Messages"





if __name__ == "__main__":
    app.run(host="0.0.0.0")
