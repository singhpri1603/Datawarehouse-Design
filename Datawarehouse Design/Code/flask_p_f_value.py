from flask import Flask, request, url_for

from flask import Response
import json
import random

from scipy import stats



app = Flask(__name__)
app.secret_key = 'This is really unique and secret'

@app.route('/')
def hello_person():
    return """
        <p>Who do you want me to say "Hi" to?</p>
        <form method="POST" action="%s"><input name="person" /><input type="submit" value="Go!" /></form>
        """ % (url_for('greet'),)

@app.route('/greet', methods=['POST'])
def greet():
    greeting = random.choice(["Hiya", "Hallo", "Hola", "Ola", "Salut", "Privet", "Konnichiwa", "Ni hao"])
    pval = stats.t.sf(3.120, 8)*2
    #pval=22
    return """
        <p>%s, %s, %s!</p>
        <p><a href="%s">Back to start</a></p>
        """ % (greeting, request.form["person"], pval ,url_for('hello_person'))


@app.route('/greet2')
def greet2():
    # greeting = random.choice(["Hiya", "Hallo", "Hola", "Ola", "Salut", "Privet", "Konnichiwa", "Ni hao"])
    val = request.args.get('val')
    degree = request.args.get('degree')
    pval = stats.t.sf(val, 8)*2
    #pval=22

    return Response(json.dumps({'pval': pval}),  mimetype='application/json')
    # return """
    #     <p>%s, %s, %s!</p>
    #     <p><a href="%s">Back to start</a></p>
    #     """ % (greeting, task_id, pval ,url_for('hello_person'))

# @app.route('/todo/api/v1.0/tasks/<int:task_id>/<int:task_id>', methods=['GET'])
# def get_task(task_id):
#     task = [33,44,66]
#     # if len(task) == 0:
#     #     abort(404)
#     return jsonify({'task': task[0]})


@app.route('/adhoc_test/')
def adhoc_test():
    val = request.args.get('val')
    degree = request.args.get('degree')
    pval = stats.p.sf(float(val), int(degree))*2
    return Response(json.dumps({'pval': pval}),  mimetype='application/json')

@app.route('/adhoc_ftest/')
def adhoc_ftest():
    F = request.args.get('val')
    df1 = request.args.get('degree1')
    df2 = request.args.get('degree2')
    pval = stats.f.sf(float(F), int(df1), int(df2))
    return Response(json.dumps({'pval': pval}),  mimetype='application/json')