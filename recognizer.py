import cv2, numpy as np
import xlwrite as exl
import time
import sys
import pickle
import os
from tkinter import *
from tkinter import messagebox
import sqlite3
from sqlite3 import Error
from datetime import date

def convertToBinaryData(filename):
    #Convert digital data to binary format
    with open(filename, 'rb') as file:
        blobData = file.read()
    return blobData
def insertBLOB(rn, date, photo):
    try:
        print(rn)
        sqliteConnection = sqlite3.connect('attendancedb.db')
        cursor = sqliteConnection.cursor()
        print("Connected to SQLite")
        sqlite_insert_blob_query = '''INSERT INTO "'''+rn+'''"(date, attend, photo) VALUES (?, ?, ?)'''

        empPhoto = convertToBinaryData(photo)
        # Convert data into tuple format
        data_tuple = (date,"yes", empPhoto)
        cursor.execute(sqlite_insert_blob_query, data_tuple)
        #print("inserted att")
        sqliteConnection.commit()
        sql=r'''select count(*) from 'working_dates' '''
        d=sqliteConnection.execute(sql)
        for r in d:
            total=r[0]
        #print(total)
        sql='''update attendance set tdays=? where id=? ''';
        #print(sql)
        data_tuple=(total,rn)
        cursor.execute(sql,data_tuple)
        #print("update date")
        sqliteConnection.commit()
        sql=r'''select count(*) from "'''+rn+'''"''';
        d=cursor.execute(sql)
        for r in d:
            days=r[0]
        sql='''update attendance set attended=? where id=? ''';
        days=days
        data_tuple=(days,rn)
        cursor.execute(sql,data_tuple)
        #print(days)
        per=(days*100)/total
        sql='''update attendance set percentage=? where id=? ''';
        #print(sql)
        data_tuple=(per,rn)
        cursor.execute(sql,data_tuple)
        #print(per)
        sqliteConnection.commit()
        print("aatendence posted")
        cursor.close()

    except sqlite3.Error as error:
        print("Failed to insert blob data into sqlite table", error)
    finally:
        if (sqliteConnection):
            sqliteConnection.close()
            print("the sqlite connection is closed")

def check_folder(path):
    dir = os.path.dirname(path)
    if not os.path.exists(dir):
        os.makedirs(dir)
start=time.time()
period=8
face_cas=cv2.CascadeClassifier('haarcascades/haarcascade_frontalface_alt2.xml')
cap = cv2.VideoCapture(0)
recognizer = cv2.face.LBPHFaceRecognizer_create()
recognizer.read('training/training.yml')

lables={}
with open("lables.pickle",'rb') as f:
        t_lables=pickle.load(f)
        lables={v:k for k,v in t_lables.items()}
found=False
flag=0
id=0
filename='filename'
dict=[]
#root = tkinter.Tk()

font=cv2.FONT_HERSHEY_SIMPLEX
while(not found):
    ret, img=cap.read()
    g = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
    faces = face_cas.detectMultiScale(g, 1.3, 5)
    for (x,y,w,h) in faces:
        r_g=g[y:y+h, x:x+w]
        cv2.rectangle(img,(x,y),(x+w,y+h),(255,0,0),2)
        id,conf=recognizer.predict(r_g)
        if(conf>=45 and conf<=60):
            rn=lables[id]
            

               
            if(id not in dict):
                    today=str(date.today())
                    path="attendance_images/"+rn+"/"
                    check_folder(path)
                    path=path+today+".jpg"
                    #print(path)
                    cv2.imwrite(path, r_g)
                    insertBLOB(rn, today, path)
                    filename=exl.output('attendance','class1',id,rn,'yes')
                    dict.append(id)
                    cv2.putText(img,str(rn)+"   "+str(int(conf)),(x,y-10),font,0.5,(120,255,120),1)
            else:
                cv2.putText(img,"already attended",(x,y-10),font,0.5,(120,255,120),1)
             
        else:
            cv2.putText(img,"not recognized"+str(int(conf)),(x,y-10),font,0.55,(0,0,255),1)
    cv2.imshow('frame',img)
    if(flag == 10):
        print("error")
        break
    elif(time.time()>(start+period)*2):
        break
    elif(cv2.waitKey(100) & 0xFF == ord('q')):
        break
cap.release()
cv2.destroyAllWindows()
