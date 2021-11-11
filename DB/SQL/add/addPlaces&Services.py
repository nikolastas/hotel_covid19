import pymysql
db = pymysql.connect(host='localhost',user='root',passwd='', database="projectdb")
cursor = db.cursor()
from random import randrange
from datetime import timedelta
import pandas as pd
import numpy as np
Services = pd.read_csv("./services.csv", sep=";")
Places = pd.read_csv("./places.csv", sep=";")
import random
import time
def act(query):
    cursor.execute(query)
    

#----------registration required & not-------------------------------
for i in range(len(Services)):
    service_id=Services['service_id'][i]
    
    service_description=Services['service_description'][i]
    #print(service_id,service_description,i)
    sqlFormula = """INSERT INTO services (service_id,service_description) 
                    VALUES ('{}','{}')""".format(service_id,service_description)
    cursor.execute(sqlFormula)
    db.commit() #Save Data
    if(i<=2 or i==6) :
        sqlFormula = """INSERT INTO registered_services (service_id) 
                    VALUES ('{}')""".format(service_id)
        act(sqlFormula)
        db.commit()
    elif(i<=5 and not(i==6)):
        sqlFormula = """INSERT INTO no_registered_services (service_id) 
                    VALUES ('{}')""".format(service_id)
        act(sqlFormula)
        db.commit()
#----------------Places-----------------------------------------------
help_temp_service_id=[4,2,3,3,6,6,5,1,1]
for j in range(len(Places)):
    number_of_beds=Places['number_of_rooms'][j]
    name=Places['name'][j]
    place_id=Places['place_id'][j]
    place_description=Places['place_description'][j]
    sqlFormula = """INSERT INTO places (number_of_beds,name,place_description,place_id) 
                    VALUES ({},'{}','{}',{})""".format(number_of_beds,name,place_description,place_id)
    act(sqlFormula)
    db.commit()
    if (j<9):
        temp_service_id= help_temp_service_id[j]
        
        sqlFormula="""INSERT INTO is_provided_to (service_id,place_id) 
                    VALUES ({},{})""".format(temp_service_id,place_id)
        act(sqlFormula)
        db.commit
#-----------------------------------------------------------------------



    
def str_time_prop(start, end, time_format, prop):
    """Get a time at a proportion of a range of two formatted times.

    start and end should be strings specifying times formatted in the
    given format (strftime-style), giving an interval [start, end].
    prop specifies how a proportion of the interval to be taken after
    start.  The returned time will be in the specified format.
    """

    stime = time.mktime(time.strptime(start, time_format))
    etime = time.mktime(time.strptime(end, time_format))

    ptime = stime + prop * (etime - stime)

    return time.strftime(time_format, time.localtime(ptime))


def random_date(start, end, prop):
    return str_time_prop(start, end, '%Y-%m-%d %H:%M:%S', prop)
    


cardAll = np.arange(1,30,1)
CostAll = np.arange(1,200,0.1)
year,month,day = np.arange(2020,2021,1), np.arange(1,12,1), np.arange(1,29,1)
hour,minute,second = np.arange(0,23,1), np.arange(0,59,1), np.arange(0,59,1)
for i in range(20):
    total_cost = np.random.choice(CostAll)
    trans_date = "-".join([str(np.random.choice(year)),str(np.random.choice(month)), str(np.random.choice(day))])
    hours = np.random.choice(hour)
    minutes = np.random.choice(minute)
    secs = np.random.choice(second)
    hours2 = hours + np.random.choice(hour)
    while hours2>23:
        hours3=np.random.choice(hour)
        if ((hours3<hours2) and ((hours2 - hours3) > hours)):
            hours2 = hours2 - hours3
    start_date_costumer_arrives="-".join([str(np.random.choice(year)),str(np.random.choice(month)), str(np.random.choice(day))]) +" " +":".join([str(np.random.choice(hour)),str(np.random.choice(minute)),str(np.random.choice(second))])
    
    while True:
        end_date_costumer_leaves="-".join([str(np.random.choice(year)),str(np.random.choice(month)), str(np.random.choice(day))]) +" " +":".join([str(np.random.choice(hour)),str(np.random.choice(minute)),str(np.random.choice(second))])
        if (start_date_costumer_arrives < end_date_costumer_leaves):
            break
    random_number_of_uses_or_visits=np.random.choice(10)
    date_of_use_of_service=start_date_costumer_arrives
    #pairnw dedomena apo np.random(1,10,1) gia paid services kai gia np.random(10,17,1) kai kanw anamesa to use kai gia tis duo periptwseis
    for i in range(random_number_of_uses_or_visits):
        time1=random_date(date_of_use_of_service, end_date_costumer_leaves, random.random())
        
        time2=random_date(time1, end_date_costumer_leaves, random.random())
        date_of_use_of_service=time2
        #print("Costumer arrives:",start_date_costumer_arrives, " ",time1," ",time2," ","Costumer leaves: " ,(end_date_costumer_leaves))
    
    #print("new line")
    trans_time = ":".join([str(hours),str(minutes), str(secs)])

    