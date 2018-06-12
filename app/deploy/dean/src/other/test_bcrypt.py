#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Thu May 17 04:21:53 2018

@author: maxim
"""

from flask import Flask
from flask.ext.bcrypt import Bcrypt

app = Flask(__name__)
bcrypt = Bcrypt(app)

pw = 'student123'
pw_hash = bcrypt.generate_password_hash(pw)
print(pw_hash)

pw_hash_php = '$2y$12$rHOSc7iGCUDgU00ReAMVN.0/8Iw90ENcxBBAy8rDVemF9LmNQ8zV.'

print(bcrypt.check_password_hash(pw_hash_php, pw))