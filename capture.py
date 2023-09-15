import cv2
import os
import sqlite3
from sqlite3 import Error

def check_folder(path):
    dir = os.path.dirname(path)
    if not os.path.exists(dir):
        os.makedirs(dir)
        
s_id=input("enter student id ")
s_id=s_id.upper()
pwd=input("enter password ")

year=int(input("enter your year"))
try:
    conn = sqlite3.connect('attendancedb.db')
    cursor=conn.cursor()
    sql=r'''create table "'''+s_id+'''" ("date" TEXT PRIMARY KEY,"attend" TEXT NOT NULL,"photo" BLOB);'''
    #print(sql)
    conn.execute(sql)
    sql=r'''Insert into 'login' (username,password) values(?,?);''';
    data_tuple = (s_id,pwd);
    cursor.execute(sql, data_tuple);
    conn.commit()
    sql=r'''select count(*) from 'working_dates' '''
    d=conn.execute(sql)
    for r in d:
        total=r[0]
    cursor=conn.cursor();
    sql=r'''Insert into 'attendance' (id,tdays,attended,percentage,suspended,year) values(?,?,?,?,?,?);''';
    data_tuple = (s_id,total,0,0,'no',year);
    cursor.execute(sql, data_tuple);
    
    conn.commit()
    cursor.close()
    conn.close()
except sqlite3.Error as er:
    print(er)
    

cam=cv2.VideoCapture(0)

f_d=cv2.CascadeClassifier('haarcascades/haarcascade_frontalface_alt2.xml')

count=0
check_folder('facedata/')

while(True):
    _, img_frame=cam.read()

    g=cv2.cvtColor(img_frame, cv2.COLOR_BGR2GRAY)

    f=f_d.detectMultiScale(g,scaleFactor=1.5,minNeighbors=5)

    for (x,y,w,h) in f:
        cv2.rectangle(img_frame,(x,y),(x+w,y+h),(255,0,0),2)
        count+=1
        cv2.imwrite("facedata/user."+str(s_id)+'.'+str(count)+".jpg", g[y:y+h,x:x+w])
    if cv2.waitKey(100) & 0xFF == ord('q'):
         break
    elif count>=30:
         print("Successfull Captured")
         break
    cv2.imshow("frame",img_frame)

cam.release()
cv2.destroyAllWindows()
        
