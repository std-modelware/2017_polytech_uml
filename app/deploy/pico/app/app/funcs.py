from app import app, mysql, bcrypt
from flask import Response
from flask import request
from flask import jsonify
import re
from datetime import datetime, timedelta
import time


t_delta = 2


regexps = [
    '^(http|https)://[a-zA-Z0-9\:\.]+\/dean\/[a-zA-Z]+\/[a-zA-Z\.\_]+$', #dean/blabla/blabla
    '^(http|https)://[a-zA-Z0-9\:\.]+\/dean\/[a-zA-Z]+\/[a-zA-Z\.\_]+\/[0-9]+$', #dean/blabla/blabla/account_id
    '^(http|https)://[a-zA-Z0-9\:\.]+\/dean\/[a-zA-Z]+\/[a-zA-Z\.\_]+\/[0-9]+\/[0-9]+$', #dean/blabla/blabla/group_id/discipline_id
    '^(http|https)://[a-zA-Z0-9\:\.]+\/task\/[a-zA-Z]+$', #task/blabla
    '^(http|https)://[a-zA-Z0-9\:\.]+\/task\/[a-zA-Z]+\/[0-9]+$', #task/blabla/test_id
    '^(http|https)://[a-zA-Z0-9\:\.]+\/tests\/[a-zA-Z]+$', #tests/blabla
    '^(http|https)://[a-zA-Z0-9\:\.]+\/tests\/[a-zA-Z]+\/[0-9]+$', #tests/blabla/id
    '^(http|https)://[a-zA-Z0-9\:\.]+\/tests\/[a-zA-Z]+\/[a-zA-Z]+\/[0-9]+$', #tests/blabla/blabla/id
    '^(http|https)://[a-zA-Z0-9\:\.]+\/[a-zA-Z]+$', #subgroups or solutions
    '^(http|https)://[a-zA-Z0-9\:\.]+\/subgroups\/[0-9]+$', #subgroups/subgroup_id
    '^(http|https)://[a-zA-Z0-9\:\.]+\/subgroups\/student\/[0-9]+$', #subgroups/student/student_id    
    '^(http|https)://[a-zA-Z0-9\:\.]+\/solutions\/[0-9]+$', #solutions/some_id
    '^(http|https)://[a-zA-Z0-9\:\.]+\/solutions\/[a-zA-Z]+\/[0-9]+$', #solutions/blabla/some_id    
    ]


@app.route('/')
def index():
    resp = jsonify({'msg': 'Test'})
    resp.status_code = 200
    return (bcrypt.generate_password_hash('password6'))


@app.route('/add', methods=['POST'])
def add():
    data = request.json
    role_id = data['role_id']
    operation = data['operation']
    methods = data['methods'].split('/')
    
    cnx = mysql.connect()
    cursor = cnx.cursor()
    select_stmt = (
        'SELECT id '
        'FROM operations '
        'WHERE (name) = %s'
        )
    cursor.execute(select_stmt, operation)

    if 'POST' in methods:
        post_state = bool(1)
    else : post_state = bool(0)
    if 'GET' in methods:
        get_state = bool(1)
    else : get_state = bool(0)
    if 'PUT' in methods:
        put_state = bool(1)
    else : put_state = bool(0)
    if 'DELETE' in methods:
        delete_state = bool(1)
    else : delete_state = bool(0)
        
    print(post_state,get_state,put_state, delete_state)
    
    if cursor.rowcount == 0:
        insert_stmt = (
            'INSERT INTO operations (name) '
            'VALUES (%s)'
            )   
        cursor.execute(insert_stmt, operation)
        cursor.execute('SELECT LAST_INSERT_ID()')
        row = cursor.fetchone()
        op_id = row[0]
        cnx.commit()
        insert_stmt = (
            'INSERT INTO access_rules '
            'VALUES (DEFAULT, %s, %s, %s, %s, %s, %s)'
            )
        print (insert_stmt)
      
        insert_data=(role_id, op_id, post_state, get_state, put_state, delete_state)       
        cursor.execute(insert_stmt, insert_data)
        cnx.commit()
    else:
        row = cursor.fetchone()
        op_id = row[0]
        select_stmt = (
            'SELECT t1.GET, t1.POST, t1.PUT, t1.DELETE '
            'FROM access_rules t1 '
            'WHERE op_id = %s AND role_id = %s'
            )
        select_data = (op_id, role_id)
        cursor.execute(select_stmt, select_data)
        if cursor.rowcount > 0:
            row = cursor.fetchone()
            get_state = get_state or row[0]
            post_state = post_state or row[1]
            put_state = put_state or row[2]
            delete_state = delete_state or row[3]
            
            update_stmt = (
                'UPDATE access_rules as t1 '
                'SET t1.GET = %s, t1.POST = %s, t1.PUT = %s, t1.DELETE = %s '
                'WHERE op_id = %s AND role_id = %s'
            )
            update_data = (get_state, post_state, put_state, delete_state, op_id, role_id)
            cursor.execute(update_stmt, update_data)
            cnx.commit()
        else:            
            insert_stmt = (
                'INSERT INTO access_rules '
                'VALUES (DEFAULT, %s, %s, %s, %s, %s, %s)'
                )
            print (insert_stmt)
              
            insert_data=(role_id, op_id, post_state, get_state, put_state, delete_state)       
            cursor.execute(insert_stmt, insert_data)
            cnx.commit()
        
    cursor.close()
    cnx.close()
    resp = jsonify()
    resp.status_code = 200
    return resp


@app.route('/login', methods=['POST'])
def login():
    data = request.json
    login = data['login']
    password = str(data['password'])
    
    cnx = mysql.connect()
    cursor = cnx.cursor()               
    select_stmt = (
        'SELECT password, id, role_id '
        'FROM accounts '
        'WHERE login = %s'
        )
    cursor.execute(select_stmt, login)
    row = cursor.fetchone()
    
    if row is None:
        resp = jsonify({
            'status_code': 200,
            'status': bool(0),
            'msg': 'Incorrect login or password'
            }
        )
        print ('Incorrect login')
    elif bcrypt.check_password_hash(row[0], password):
        user_id = row[1]
        role_id = row[2]
        current_date_time = datetime.utcnow()
                
        token = bcrypt.generate_password_hash(str(user_id)\
                                              + str(current_date_time))
        exp_date = current_date_time + timedelta(hours=t_delta) #time session is 2 hours
        
        insert_stmt = (
            'INSERT INTO sessions (token, timestamp, user_id) '
            'VALUES (%s, %s, %s)'
            )        
        insert_data = (token, exp_date, user_id)
        
        cursor.execute(insert_stmt, insert_data)
        cnx.commit()
        
        resp = jsonify({
            'status_code': 200,
            'status': bool(1),
            'token': token,
            'role_id': role_id
            }
        )
        print ('New session created')
    else:      
        resp = jsonify({
            'status_code': 200,
            'status': bool(0),
            'msg': 'Incorrect login or password'
            }
        )
        print ('Incorrect password')
    
    cursor.close()
    cnx.close()

    resp.status_code = 200
    return resp


def create_resp(status_code, msg):
    resp = jsonify({
        'status_code': status_code,
        'msg': msg
        }
    )         
    resp.status_code = status_code    
    return resp


def get_operation(words, num):
    operation = words.pop()
    for i in range (num - 1):
        operation = words.pop() + '/' + operation

    return operation


@app.route('/check', methods=['POST'])
def check():   
    data = request.json
    method = data['method']
    url = data['url']
    token = data['token']  
       
    cnx = mysql.connect()
    cursor = cnx.cursor()               
    select_stmt = (
        'SELECT timestamp, user_id '
        'FROM sessions '
        'WHERE token = %s'
        )
    cursor.execute(select_stmt, token)
    
    if cursor.rowcount > 0:   #check that session exists
        print ('Session exists')
        
        row = cursor.fetchone()       
        timestamp = row[0]            
        current_user_id = row[1]      
        
        current_date_time = datetime.utcnow()
                
        if timestamp > current_date_time:  #check that session is active
            print ('Session is active')
            
            select_stmt = (
                'SELECT role_id '
                'FROM accounts '
                'WHERE id = %s'
                )                   
            cursor.execute(select_stmt, current_user_id)
            
            row = cursor.fetchone()            
            role_id = row[0]
            print ('Role id is {}'.format(role_id))

            words = url.split('/')
           
            if re.match(regexps[0],url):    #dean/blabla/blabla
                print ('dean/.../...')
                operation = get_operation(words, 3)
            elif re.match(regexps[1],url):  #dean/blabla/blabla/account_id
                print('dean/.../.../account_id')
                user_id = int(words.pop())
                operation = get_operation(words, 3) + '/'              
                print (current_user_id)
                if current_user_id != user_id:
                    print ('Users are not the same')
                    resp = create_resp(403, 'Operation forbidden') 
                    return resp
                    
                else:
                    print ('Users are the same')                                    
               
            elif re.match(regexps[2],url):  #dean/blabla/blabla/group_id/discipline_id
                print('dean/.../.../group_id/discipline_id')
                discipline_id = words.pop()
                group_id = words.pop()                
                operation = get_operation(words, 3) + '//'
                                
                select_data = (current_user_id, group_id, discipline_id)
                if role_id == 2:                    
                    select_stmt = (
                        'SELECT * FROM students t1 '                        
                        'JOIN currentdeals t2 '
                        'ON t1.groups_id = t2.groups_id '
                        'WHERE t1.accounts_id = %s and t2.groups_id = %s and t2.disciplines_id = %s'
                        )                    
                else:
                    select_stmt = (
                        'SELECT * FROM teachers t1 '                        
                        'JOIN currentdeals t2 '
                        'ON t1.id = t2.teachers_id '
                        'WHERE t1.accounts_id = %s and t2.group_id = %s and t2.disciplines_id = %s'
                        )
                    
                cursor.execute(select_stmt, select_data)
                if cursor.rowcount == 0:
                    print ('Operation forbidden')
                    resp = create_resp(403, 'Operation forbidden')
                    cursor.close()
                    cnx.close()
                    return resp
                else:
                    print ('OK')
                cursor.fetchall()
                
            elif re.match(regexps[3],url):  #task/blabla
                print('task/...')
                operation = get_operation(words, 2)
            elif re.match(regexps[4],url):  #task/blabla/test_id
                print('task/.../test_id')
                test_id = int(words.pop())
                operation = get_operation(words, 2) + '/'
            elif re.match(regexps[5],url): #tests/blabla
                print('tests/...')                
                operation = get_operation(words, 2) 
            elif re.match(regexps[6],url): #tests/blabla/id
                print('tests/.../id')
                cond_id = int(words.pop())
                operation = get_operation(words, 2) + '/' 
            elif re.match(regexps[7],url): #tests/blabla/blabla/id
                print('tests/.../.../id')
                user_id = int(words.pop())
                operation = get_operation(words, 3) + '/' 
            elif re.match(regexps[8],url): #subgroups or solutions
                print('...')                
                operation = get_operation(words, 1)
            elif re.match(regexps[9],url): #subgroups/subgroup_id
                print('subgroups/subgroup_id')
                subgroup_id = int(words.pop())
                operation = get_operation(words, 1) + '/' 
            elif re.match(regexps[10],url): #subgroups/student/student_id
                print('subgroups/student/student_id')
                student_id = int(words.pop())
                operation = get_operation(words, 2) + '/'
            elif re.match(regexps[11],url): #solutions/some_id
                print('solutions/some_id')
                some_id = int(words.pop())
                operation = get_operation(words, 1) + '/'
            elif re.match(regexps[12],url): #solutions/blabla/some_id  
                print('solutions/.../some_id')
                some_id = int(words.pop())
                operation = get_operation(words, 2) + '/'
            else:
                print ('Oooppppss...Invalid URL')                
                resp = create_resp(404, 'Invalid URL')
                cursor.close()
                cnx.close()
                return resp

            #Check rules for current user            
            select_stmt = (
                'SELECT t1.' + method + ' FROM access_rules t1 '
                'JOIN operations t2 '
                'ON t1.op_id = t2.id '
                'WHERE t2.name = %s AND t1.role_id = %s'
                )
            
            #print (select_stmt)
            print ('Operation is {}'.format(operation))
            #print (role_id)           
            select_data = (operation, role_id)
            cursor.execute(select_stmt, select_data)
           
            if cursor.rowcount > 0:
                row = cursor.fetchone()
                access_rule = row[0]
                #print (access_rule)

                if access_rule:
                    print ('Operation is available for current user')
                    resp = jsonify({'status_code': 200, 'msg': 'OK'})
                    resp.status_code = 200
                else:                       
                    print ('Oooppppss...operation is not available for current user')                    
                    resp = create_resp(403, 'Operation forbidden')                                 
            else:
                print ('Oooppppss...Invalid operation')
                resp = create_resp(404, 'Invalid operation')                                   
        else:
            print('Session time is over')            
            delete_stmt = (
                'DELETE '
                'FROM sessions '
                'WHERE token = %s'
                )
            cursor.execute(delete_stmt, token)
            cnx.commit()           
            resp = create_resp(404, 'Session time is over')
            print('Session deleted')            
    else:
        print ('Session is not exist')        
        resp = create_resp(404, 'Session is not exist')
        
    cursor.close()
    cnx.close()
    return resp


@app.route('/logout', methods=['POST'])
def logout():
    data = request.json
    url = data['url']
    token = data['token']

    words = url.split('/')
    user_id = int((words.pop())[2:])
    
    cnx = mysql.connect()
    cursor = cnx.cursor()               
    select_stmt = (
        'SELECT user_id '
        'FROM sessions '
        'WHERE token = %s'
        )
    cursor.execute(select_stmt, token)

    if cursor.rowcount > 0:
        row = cursor.fetchone()
        current_user_id = row[0]
               
        if current_user_id == user_id:
            delete_stmt = (
                'DELETE '
                'FROM sessions '
                'WHERE token = %s'
                )
            cursor.execute(delete_stmt, token)
            cnx.commit()
            resp = jsonify({'status_code': 200, 'status': bool(1)})
            print ('Session deleted')
        else:
            print ('Users do not match')
            resp = jsonify({
                'status_code': 200,
                'status': bool(0),
                'msg': 'Users do not match'
                }
            ) 

    else:
        print ('Session does not exist')
        resp = jsonify({
            'status_code': 200,
            'status': bool(0),
            'msg': 'Session does not exist'
            }
        )    
        
    resp.status_code = 200
    cursor.close()
    cnx.close()
    
    return resp
