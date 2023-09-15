#import module from tkinter for UI
from tkinter import *
#from playsound import playsound
import os
from subprocess import Popen
from tkinter import messagebox
from pathlib import Path
import pickle
from datetime import date
import sqlite3
from sqlite3 import Error
import webbrowser

#creating instance of TK
root=Tk()

root.configure(background="white")

#root.geometry("300x300")

dates=[]
with open("dates.pickle",'rb') as f:
        dates=pickle.load(f)

#print(dates)

def function1():
    
    Popen("python capture.py")
    
def function2():
    
    Popen("python training_data.py")

def function3():
    today=str(date.today())
    if(today in dates):
        Popen("python recognizer.py")
    else:
        messagebox.showerror("ERROR","date not found add it")
    #os.system("start localhost/Online-Banking-system-master")
    # playsound('sound.mp3')

def function5():    
   #os.startfile(os.getcwd()+"/developers/diet1frame1first.html");
    #pwd=input("enter password:")
    today=str(date.today())
    with open("dates.pickle",'wb') as f:
        dates.append(today)
        #print(dates)
        pickle.dump(dates,f)
    with open("lables.pickle",'rb') as f:
        t_lables=pickle.load(f)
    try:
        sqliteConnection = sqlite3.connect('attendancedb.db')
        cursor=sqliteConnection.cursor()
        print("Connected to Sqlite")
        sqlite_insert_date='''INSERT INTO "working_dates"  (date) VALUES("'''+today+'''")'''
        #d_t=today
        cursor.execute(sqlite_insert_date)
        sqliteConnection.commit()
        print("date is added")
        for i in t_lables:
            sql=r'''select count(*) from 'working_dates' '''
            d=sqliteConnection.execute(sql)
            for r in d:
                total=r[0]
            #print(total)
            sql='''select attended from attendance where id="'''+i+'''"''';
            d=cursor.execute(sql)
            for r in d:
                days=r[0]
            per=(days*100)/total
            #print(per)
            sql='''update attendance set tdays=? where id=? ''';
            #print(sql)
            data_tuple=(total,str(i))
            cursor.execute(sql,data_tuple)
            sqliteConnection.commit()
            sql='''update attendance set percentage=? where id=? ''';
            #print(sql)
            data_tuple=(per,str(i))
            cursor.execute(sql,data_tuple)
            sqliteConnection.commit()
            cursor.close()
    except sqlite3.Error as error:
        print("failed to add date")
        print(error)
    finally:
        if (sqliteConnection):
            sqliteConnection.close()
            print("the sqlite connection is closed")
    
        
   
def function6():

    root.destroy()
def function7():
    url = 'localhost/4-2'
    webbrowser.open(url, new=2)
    
def attend():
    my_file = Path(os.getcwd()+'attendance_files/attendance'+str(datetime.now().date())+'.xls');
    if my_file.is_file():
        os.startfile(os.getcwd()+"/attendance_files/attendance"+str(datetime.now().date())+'.xls')
    else:
        messagebox.showinfo("error","file not found")
        
#stting title for the window
root.title("AUTOMATIC ATTENDANCE MANAGEMENT USING FACE RECOGNITION")


#creating a text label
Label(root, text="SMART ATTENDANCE SYSTEM",font=("times new roman",20),fg="white",bg="blue",height=2).grid(row=0,rowspan=2,columnspan=2,sticky=N+E+W+S,padx=5,pady=5)

#add a date to table
Button(root,text="Add Working Day",font=('times new roman',20),bg="#0D47A1",fg="white",command=function5).grid(row=3,columnspan=2,sticky=W+E+N+S,padx=5,pady=5)

#creating first button
Button(root,text="Create Dataset",font=("times new roman",20),bg="#0D47A1",fg='white',command=function1).grid(row=4,columnspan=2,sticky=N+E+W+S,padx=5,pady=5)

#creating second button
Button(root,text="Train Dataset",font=("times new roman",20),bg="#0D47A1",fg='white',command=function2).grid(row=5,columnspan=2,sticky=N+E+W+S,padx=5,pady=5)

#creating third button
Button(root,text="Recognize",font=('times new roman',20),bg="#0D47A1",fg="white",command=function3).grid(row=6,columnspan=2,sticky=N+E+W+S,padx=5,pady=5)

#creating attendance button
Button(root,text="Check Attendance",font=('times new roman',20),bg="#0D47A1",fg="white",command=function7).grid(row=9,columnspan=2,sticky=N+E+W+S,padx=5,pady=5)

#Button(root,text="Developers",font=('times new roman',20),bg="#0D47A1",fg="white",command=function5).grid(row=8,columnspan=2,sticky=N+E+W+S,padx=5,pady=5)

Button(root,text="Exit",font=('times new roman',20),bg="maroon",fg="white",command=function6).grid(row=12,columnspan=2,sticky=N+E+W+S,padx=5,pady=5)


root.mainloop()
