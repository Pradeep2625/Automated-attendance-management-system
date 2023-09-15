import os,cv2;
import numpy as np
from PIL import Image
import pickle

recognizer = cv2.face.LBPHFaceRecognizer_create()
detector= cv2.CascadeClassifier('haarcascades/haarcascade_frontalface_alt2.xml');

def getImagesAndLabels(path):
    
    imagePaths=[os.path.join(path,f) for f in os.listdir(path)]
    current_id=1
    lables_ids={}
    x_train=[]
    y_lables=[]
    for imagePath in imagePaths:
        pilImage=Image.open(imagePath).convert('L')
        imageNp=np.array(pilImage,'uint8')
        faces=detector.detectMultiScale(imageNp)  #,scaleFactor=1.5,minNeighbors=5
        #print(faces)
        tmp=imagePath.split('.')[0:-1]
        rn=tmp[1]
        if not rn in lables_ids:
            lables_ids[rn]=current_id
            current_id+=1
        id_=int(lables_ids[rn])
        #print(id_)
        '''ch=rn[-2]
        if(ord(ch)<65):
            n=int(ch)
            n=(n*10)+int(rn[-1])
        else:
            n=ord(ch)-55
            n=(n*10)+int(rn[-1])
        id_=n'''
         
        #print(id_)
        for (x,y,w,h) in faces:
            roi=imageNp[y:y+h,x:x+w]
            #print(roi,id_)
            x_train.append(roi)
            y_lables.append(id_)
    with open("lables.pickle",'wb') as f:
        pickle.dump(lables_ids,f)
    return x_train,y_lables

x_train,y_lables = getImagesAndLabels('facedata')
s = recognizer.train(x_train,np.array(y_lables))
print("Successfully trained")
recognizer.write('training/training.yml')

