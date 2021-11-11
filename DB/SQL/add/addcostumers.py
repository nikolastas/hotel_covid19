#!C:\Users\Nikos\AppData\Local\Programs\Python\Python39\python.exe


from numpy.lib.function_base import place
import pymysql
db = pymysql.connect(host='localhost',user='root',passwd='', database="projectdb")
cursor = db.cursor()
from random import randrange
from datetime import timedelta
import datetime
import random
import time
import pandas as pd
import numpy as np
People = pd.read_csv("./costumers.csv", sep=";")
Services = pd.read_csv("./services.csv", sep=";")
Places = pd.read_csv("./places.csv", sep=";")
#print(People)
#-------------COSTUMER INFO HELP ---------------
LENGTH = 10
NO_CODES = 100000

def act(query):
    cursor.execute(query)

alphabet = list('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789')
np_alphabet = np.array(alphabet, dtype="|U1")
np_codes = np.random.choice(np_alphabet, [NO_CODES, LENGTH])
codes = ["".join((np_codes[i])) for i in range(len(np_codes))]
#-----------------DEFINITIONS----------------
def str_time_prop(start, end, time_format, prop):    
    stime = time.mktime(time.strptime(start, time_format))
    etime = time.mktime(time.strptime(end, time_format))
    ptime = stime + prop * (etime - stime)
    return time.strftime(time_format, time.localtime(ptime))


def random_date(start, end, prop):
    return str_time_prop(start, end, '%Y-%m-%d %H:%M:%S', prop)
                
#----------------------DATES----------------------------------------
year,month,day = [2020,2021], [5,6], np.arange(1,28,1)

hour,minute,second = np.arange(0,23,1), np.arange(0,59,1), np.arange(0,59,1)
#------------------------RANDOM NUMBER----------------------------------------




random_registered_service=np.arange(1,4,1)
temp_human=np.arange(0,2,1)
phones = np.arange(2100000000,2109999999)
temp_charge_amount_per_service=np.arange(0,300,1)
temp_charge_amount_per_registered_service=np.arange(50,200)
temp_amount_for_room=np.arange(70,250)
#---------------------------------------------------------------------
place_id_to_service_id=[4,2,3,3,6,6,5,1,1]

for i in range(len(People)):
    nfc_id=People['nfc_id'][i]
    first_name = People['first_name'][i].replace("'","").replace('"',"")
    last_name = People['last_name'][i].replace("'","").replace('"',"") 
    email = People['email'][i]
    mobile=np.random.choice(phones)
    birth_date = People['date_of_birth'][i]
    #print(birth_date)
    certification_document_type = np.random.choice(['Passport', 'ID','Visa'])
    #------------------------------------------
    certification_document_number = np.random.choice(codes)
    #------------------------------------------
    
    certification_document_principle_of_issue =  np.random.choice(['Greek Police','Albany Authority', 'American embasy of Greece','Italian ','Chinese','German Authorities'])
    
    sqlFormula = """INSERT INTO costumer (nfc_id,first_name,last_name,date_of_birth,certification_document_type,certification_document_number,certification_document_principle_of_issue) 
                    VALUES ({},'{}','{}','{}','{}','{}','{}')""".format(nfc_id,first_name,last_name,birth_date,certification_document_type,certification_document_number,certification_document_principle_of_issue)
    act(sqlFormula)
    db.commit() #Save Data
    sqlFormula = """INSERT INTO costumer_mobile (costumer_nfc_id,costumer_mobile) 
                    VALUES ({},'{}')""".format(nfc_id,mobile)
    act(sqlFormula)
    sqlFormula = """INSERT INTO costumer_email (costumer_nfc_id,costumer_email) 
                    VALUES ({},'{}')""".format(nfc_id,email)
    act(sqlFormula)
    db.commit() #Save Data
    #-----------------------------register to services-----------------------------------------------------------------
    lamda=np.random.choice(temp_human)
    
            
            #for i in range(20):
    #minimum_start_date_costumer_arrives="-".join([str(year),str(month), str(np.random.choice(day)+1)]) +" " +":".join([str(np.random.choice(hour)),str(np.random.choice(minute)),str(np.random.choice(second))])            
    while True:
        start_time_year=np.random.choice(year)
        start_time_month=np.random.choice(month)
        start_time_day=np.random.choice(day)
        start_datetime=datetime.datetime(start_time_year,start_time_month,start_time_day)
        
        end_time_year=start_time_year
        end_time_month=np.random.choice(month)
        end_time_day=np.random.choice(day)
        end_datetime=datetime.datetime(end_time_year,end_time_month,end_time_day)

        if (start_datetime < end_datetime and (end_datetime-start_datetime).days>=10 ):
            break
        #else:
           # pass
            #print(minimum_start_date_costumer_arrives,"<" ,end_date_costumer_leaves)
    #---------------------HAVE ACCESS TO A ROOM  ----------------------------------
    end_date_costumer_leaves="-".join([str(end_time_year),str(end_time_month), str((end_time_day))]) +" " +":".join([str(np.random.choice(hour)),str(np.random.choice(minute)),str(np.random.choice(second))])
    start_date_costumer_arrives="-".join([str(start_time_year),str(start_time_month), str(start_time_day)]) +" " +":".join([str(np.random.choice(hour)),str(np.random.choice(minute)),str(np.random.choice(second))])

    sqlFormula="""INSERT INTO have_access (costumer_nfc_id,place_id,start_time,end_time) 
                                        VALUES ({},{},'{}','{}')""".format(nfc_id,nfc_id+9,start_datetime,end_datetime)  
    act(sqlFormula)
    db.commit() #Save Data
    sqlFormula="""INSERT INTO costumer_registered_to_services (costumer_id,service_id,start_time) 
                VALUES ({},{},'{}')""".format(nfc_id,7,start_date_costumer_arrives) 
    act(sqlFormula)
    db.commit() #Save Data
    #-------------------------CHARGE FOR ROOM when costumer arrives-------------------------------------
    #sqlFormula="""INSERT INTO get_service (costumer_id,service_id) 
    #            VALUES ({},{})""".format(nfc_id,7) 
    #act(sqlFormula)
   # db.commit() #Save Data
    service_detailed_description="customer: "+str(nfc_id)+" ,use of service"+str(7)+" ,one time payment for staying on room: "+str(nfc_id+9)
    amount=np.random.choice(temp_amount_for_room)
    sqlFormula="""INSERT INTO get_service (costumer_id,service_id,amount,service_detailed_description,datetime_used) 
                VALUES ({},{},{},'{}','{}')""".format(nfc_id,7,amount,service_detailed_description,start_date_costumer_arrives) 
    act(sqlFormula)
    db.commit() #Save Data



    random_number_of_uses_or_visits=np.random.choice(7)
    date_of_use_of_service=start_date_costumer_arrives
                #---------------------------visits room-----------------------------------
   
    for m in range(random_number_of_uses_or_visits):

        counter=0
        while True:
            time1=random_date(start_date_costumer_arrives,end_date_costumer_leaves,random.random())
            time2=random_date(time1, end_date_costumer_leaves, random.random())
            
            time_format='%Y-%m-%d %H:%M:%S'
            tima1=time.mktime(time.strptime(time1, time_format))
            tim1=time.strftime(time_format, time.localtime(tima1))
            tima2=time.mktime(time.strptime(time2, time_format))
            tim2=time.strftime(time_format, time.localtime(tima2))
            enda=time.mktime(time.strptime(end_date_costumer_leaves, time_format))
            end=time.strftime(time_format, time.localtime(enda))
            if (tim1<tim2 and tim1!=end and tim2!=end):
                break
        date_of_use_of_service=time2
        #print(nfc_id,"place:",temp_place,"Costumer arrives:",start_date_costumer_arrives, " ",time1," ",time2," ","Costumer leaves: " ,(end_date_costumer_leaves))
        sqlFormula="""INSERT INTO visit (costumer_nfc_id,place_id,start_time,end_time) 
                    VALUES ({},{},'{}','{}')""".format(nfc_id,nfc_id+9,time1,time2)  
        act(sqlFormula)
        db.commit() #Save Data 
    
    end=np.random.choice(random_registered_service)
    rand_list_of_services=range(1, end + 1)  
    if(lamda==1): #--------------an eggrafete se kapoia yphresia----------------------------------------
        for k in range(len(rand_list_of_services)): #---------------- 1 h 2 h 3 yphresies dhladh autes pooy apaitoun eggrafh
            temp_service=rand_list_of_services[k]
            sqlFormula="""INSERT INTO costumer_registered_to_services (costumer_id,service_id,start_time) 
                        VALUES ({},{},'{}')""".format(nfc_id,temp_service,start_date_costumer_arrives)  
            act(sqlFormula)
            db.commit() #Save Data
                        #------------------have_accesss to registered places from registered costumers ---------------
            for k in range(1,len(place_id_to_service_id)):
                if(place_id_to_service_id[k]==temp_service):
                    #print( "place id is ",k+1,"and service id is ",temp_service,"=",place_id_to_service_id[k])
                    sqlFormula="""INSERT INTO have_access (costumer_nfc_id,place_id,start_time,end_time) 
                               VALUES ({},{},'{}','{}')""".format(nfc_id,k+1,start_date_costumer_arrives,end_date_costumer_leaves)  
                    act(sqlFormula)
                    db.commit() #Save Data
                    random_number_of_uses_or_visits=np.random.choice(5)
                    date_of_use_of_service=start_date_costumer_arrives
                #---------------------------visits registered service-----------------------------------
                    for m in range(random_number_of_uses_or_visits):
                        counter=0
                        while True:
                            time1=random_date(date_of_use_of_service,end_date_costumer_leaves,random.random())
                            time2=random_date(time1, end_date_costumer_leaves, random.random())
            
                            time_format='%Y-%m-%d %H:%M:%S'
                            tima1=time.mktime(time.strptime(time1, time_format))
                            tim1=time.strftime(time_format, time.localtime(tima1))
                            tima2=time.mktime(time.strptime(time2, time_format))
                            tim2=time.strftime(time_format, time.localtime(tima2))
                            enda=time.mktime(time.strptime(end_date_costumer_leaves, time_format))
                            end=time.strftime(time_format, time.localtime(enda))
                            if (tim1<tim2 and tim1!=end and tim2!=end):
                                break
                        date_of_use_of_service=time2
                        #print(nfc_id,"place:",temp_place,"Costumer arrives:",start_date_costumer_arrives, " ",time1," ",time2," ","Costumer leaves: " ,(end_date_costumer_leaves))
                        sqlFormula="""INSERT INTO visit (costumer_nfc_id,place_id,start_time,end_time) 
                                    VALUES ({},{},'{}','{}')""".format(nfc_id,k+1,time1,time2)  
                        act(sqlFormula)
                        db.commit() #Save Data 
                        service_detailed_description="customer: "+str(nfc_id)+" use of service "+str(temp_service)+" ,one time payment at place: "+str(k+1)
                        #print(service_detailed_description)
                        amount=np.random.choice(temp_charge_amount_per_registered_service)
                        
                        sqlFormula="""INSERT INTO get_service (costumer_id,service_id,amount,service_detailed_description,datetime_used) 
                                    VALUES ({},{},{},'{}','{}')""".format(nfc_id,temp_service,amount,service_detailed_description,time1) 
                        act(sqlFormula)
                        db.commit() #Save Data
    #--------------------------have accesss to places from free services ----------------------
    for i in range(len(Places)):
        temp_place=Places['place_id'][i]
        
        if( temp_place==1 or (temp_place>4 and temp_place<8)):
            
            sqlFormula="""INSERT INTO have_access (costumer_nfc_id,place_id,start_time,end_time) 
                                        VALUES ({},{},'{}','{}')""".format(nfc_id,temp_place,start_date_costumer_arrives,end_date_costumer_leaves)  
            act(sqlFormula)
            db.commit() #Save Data


    #---------------------------------create an end date and random dates betweem them--------------------------------------------
            random_number_of_uses_or_visits=np.random.choice(5)
            date_of_use_of_service=start_date_costumer_arrives
                #pairnw dedomena apo np.random(1,10,1) gia paid services kai gia np.random(10,17,1) kai kanw anamesa to use kai gia tis duo periptwseis
            for m in range(random_number_of_uses_or_visits):
                counter=0
                while True:
                    time1=random_date(start_date_costumer_arrives,end_date_costumer_leaves,random.random())
                    time2=random_date(time1, end_date_costumer_leaves, random.random())
            
                    time_format='%Y-%m-%d %H:%M:%S'
                    tima1=time.mktime(time.strptime(time1, time_format))
                    tim1=time.strftime(time_format, time.localtime(tima1))
                    tima2=time.mktime(time.strptime(time2, time_format))
                    tim2=time.strftime(time_format, time.localtime(tima2))
                    enda=time.mktime(time.strptime(end_date_costumer_leaves, time_format))
                    end=time.strftime(time_format, time.localtime(enda))
                    if (tim1<tim2 and tim1!=end and tim2!=end):
                        break
                date_of_use_of_service=time2
                #print(nfc_id,"place:",temp_place,"Costumer arrives:",start_date_costumer_arrives, " ",time1," ",time2," ","Costumer leaves: " ,(end_date_costumer_leaves))
                sqlFormula="""INSERT INTO visit (costumer_nfc_id,place_id,start_time,end_time) 
                                            VALUES ({},{},'{}','{}')""".format(nfc_id,temp_place,time1,time2)  
                act(sqlFormula)
                db.commit() #Save Data
                service_detailed_description="customer: "+str(nfc_id)+" ,use of service "+str(place_id_to_service_id[temp_place])+" , one time payment at place: "+str(temp_place)
                amount=np.random.choice(temp_charge_amount_per_service)
                sqlFormula="""INSERT INTO get_service (costumer_id,service_id,amount,service_detailed_description,datetime_used) 
                            VALUES ({},{},{},'{}','{}')""".format(nfc_id,place_id_to_service_id[temp_place-1],amount,service_detailed_description,time1) 
                act(sqlFormula)
                db.commit() #Save Data

            
            
    


