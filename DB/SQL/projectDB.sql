


CREATE TABLE costumer(
    nfc_id int(10) AUTO_INCREMENT NOT NULL,
    first_name varchar(50), /* First name */
    last_name varchar(50), /* Last name */
    date_of_birth DATE NOT NULL ,
    certification_document_number varchar(50) NOT NULL,
    certification_document_type varchar(50) NOT NULL,
    certification_document_principle_of_issue varchar(50) NOT NULL,
    PRIMARY KEY (nfc_id)
);

/* MULTIVALUED ATTRIBUTE EMAIL */
CREATE TABLE costumer_email(
    costumer_nfc_id int(10) NOT NULL,
    costumer_email varchar(50) NOT NULL,
    FOREIGN KEY (costumer_nfc_id) REFERENCES costumer(nfc_id) ON DELETE CASCADE ON UPDATE CASCADE ,
    PRIMARY KEY (costumer_email,costumer_nfc_id)
);

/* MULTIVALUED ATTRIBUTE MOBILE */
CREATE TABLE costumer_mobile(
    costumer_nfc_id INT(10) NOT NULL,
    costumer_mobile INT(12) NOT NULL,
    FOREIGN KEY (costumer_nfc_id) REFERENCES costumer(nfc_id) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (costumer_mobile,costumer_nfc_id)
);

/* PLACES ENTITY */
CREATE TABLE places (
    number_of_beds INT(4) ,
    place_id INT (10) NOT NULL AUTO_INCREMENT,
    name VARCHAR(20) NOT NULL ,
    place_description VARCHAR(255) NOT NULL,
    PRIMARY KEY (place_id)
);

/* HAVE ACCESS RELATIONSHIP */
CREATE TABLE have_access(
    costumer_nfc_id INT (10) NOT NULL,
    place_id INT (10) NOT NULL ,
    start_time datetime,
    end_time datetime,
    FOREIGN KEY (place_id) REFERENCES places(place_id) ON DELETE CASCADE ON UPDATE CASCADE ,
    FOREIGN KEY (costumer_nfc_id) REFERENCES costumer(nfc_id) ON DELETE  CASCADE ON UPDATE CASCADE ,
    PRIMARY KEY (costumer_nfc_id,place_id,start_time,end_time)
);

/* VISITS RELATIONSHIP */
CREATE TABLE visit(
    costumer_nfc_id INT (10) NOT NULL ,
    place_id INT (10) NOT NULL ,
    start_time datetime,
    end_time datetime,
    FOREIGN KEY (place_id) REFERENCES places(place_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (costumer_nfc_id) REFERENCES costumer(nfc_id) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (costumer_nfc_id,place_id,start_time,end_time)
);

/* SERVICES ENTITY */
CREATE TABLE services (
    service_id INT(10) NOT NULL ,
    service_description VARCHAR(120),

    PRIMARY KEY (service_id)
);

/* ISA REGISTERED */
CREATE TABLE registered_services(
    service_id INT(10) NOT NULL,

    PRIMARY KEY (service_id),
    FOREIGN KEY (service_id) REFERENCES services(service_id) ON DELETE CASCADE ON UPDATE CASCADE

);

/* ISA NOT REGISTERED */
CREATE TABLE no_registered_services(
    service_id INT(10) NOT NULL,

    PRIMARY KEY (service_id),
    FOREIGN KEY (service_id) REFERENCES services(service_id) ON DELETE CASCADE ON UPDATE CASCADE
);

/* REGISTER TO SERVICE */
CREATE TABLE costumer_registered_to_services(
    costumer_id int(10) NOT NULL,
    service_id INT (10),
    start_time datetime NOT NULL,
    PRIMARY KEY (costumer_id,service_id),
    FOREIGN KEY (service_id) REFERENCES registered_services(service_id)ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (costumer_id) REFERENCES costumer(nfc_id) ON DELETE CASCADE ON UPDATE CASCADE
);

/* GET SERVICE RELATIONSHIP *//*(included SERVICE CHARGE WEAK ENTITY */
CREATE TABLE get_service (
    costumer_id INT(10) NOT NULL,
    service_id INT(10) NOT NULL,
    amount INT(9) NOT NULL,
    service_detailed_description VARCHAR(255),
    datetime_used DATETIME ,
    PRIMARY KEY (datetime_used,costumer_id,service_id),
    FOREIGN KEY (costumer_id) REFERENCES costumer(nfc_id) ON DELETE CASCADE ON UPDATE CASCADE ,
    FOREIGN KEY (service_id) REFERENCES services(service_id) ON DELETE CASCADE ON UPDATE CASCADE

);


/* IS PROVIDED TO RELATION */
CREATE TABLE is_provided_to(
    service_id int(10),
    place_id int(10),
    PRIMARY KEY (service_id,place_id),
    FOREIGN KEY (service_id) REFERENCES services(service_id),
    FOREIGN KEY (place_id) REFERENCES places(place_id)
);


CREATE INDEX index_costumer ON
costumer(nfc_id, first_name, last_name);

CREATE INDEX index_get_service ON
get_service(costumer_id,service_id,datetime_used);

CREATE INDEX index_visit ON
visit(start_time,end_time);

CREATE INDEX index_place ON
places(place_id,name);

CREATE VIEW erwthma7 AS
    SELECT first_name,last_name,nfc_id,services.service_id,service_description,amount,datetime_used
    FROM costumer , get_service , services
    WHERE costumer.nfc_id=get_service.costumer_id AND get_service.service_id=services.service_id ;

CREATE VIEW erwthma9 AS
    SELECT nfc_id,last_name,first_name,places.place_id,name,start_time,end_time
    FROM costumer , visit , places
    WHERE costumer.nfc_id=visit.costumer_nfc_id AND visit.place_id=places.place_id;

CREATE VIEW erwthma10 AS
    SELECT ER_9_1.nfc_id , ER_9_2.nfc_id as no_covid_id,ER_9_2.first_name,ER_9_2.last_name,ER_9_2.name , ER_9_2.place_id ,ER_9_2.start_time AS non_covid_start_time , ER_9_1.start_time , ER_9_1.end_time , ER_9_2.end_time AS non_covid_end_time
    FROM erwthma9 as ER_9_1 ,erwthma9 as ER_9_2
    WHERE ER_9_2.place_id=ER_9_1.place_id AND
          ER_9_1.nfc_id<>ER_9_2.nfc_id AND  (
        (ER_9_2.start_time<=ER_9_1.start_time AND ER_9_2.end_time<=DATE_ADD(ER_9_1.end_time, INTERVAL 1 HOUR) AND ER_9_2.end_time>=ER_9_1.start_time) OR
        (ER_9_2.start_time>=ER_9_1.start_time AND ER_9_2.end_time<=DATE_ADD(ER_9_1.end_time, INTERVAL 1 HOUR)  ) OR
        (ER_9_2.start_time<=ER_9_1.end_time AND ER_9_2.end_time>=DATE_ADD(ER_9_1.end_time, INTERVAL 1 HOUR))

        ) ;

CREATE VIEW erwthma8a AS
    SELECT SUM(amount) AS sum_amount,get_service.service_id, services.service_description
    FROM get_service,services
    WHERE services.service_id=get_service.service_id
    GROUP BY  service_id ASC ;

CREATE VIEW erwthma8b AS
    SELECT nfc_id, first_name, last_name, date_of_birth, certification_document_number,certification_document_type, certification_document_principle_of_issue, costumer_mobile, costumer_email
    FROM costumer, costumer_mobile ,costumer_email
    WHERE costumer.nfc_id=costumer_mobile.costumer_nfc_id and costumer.nfc_id=costumer_email.costumer_nfc_id
    ORDER BY nfc_id ASC;