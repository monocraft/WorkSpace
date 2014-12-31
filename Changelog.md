Note of changes:
c/p table renames to vtype
index heading renames Type to VendorType
OLD	ID	VendorType
9	1	Active Vendor
10	2	Banished Vendor
1	3	Banished - Failed Background
2	4	Banished - Name Change
6	5	Banished - Non-Compliant with Insurance
3	6	Banished - Poor Performance
8	7	Banished - Unresponsive
4	8	Banished - Vendor Quit to work for Safeguard
11	9	Banished - Failed Training
19	10	Banished - Poor Communication
12	11	Banished - Vendor Quit due to pricing
17	12	In Processing
18	13	Online Submission
27	14	Standby Vendor
13	15	Vendor in Assessment
16	16	Vendor Lead
26	17	Vendor on Leave
21	18	Vendor Quit
20	19	Deleted Vendor

vendor application renames to vendor
index repaired and organized
Rename: Legal Business Name > Company Name
Physical Street Address 1
Physical Street Address 2
-Remove invalid input
Physical City
-Remove invalid input
Physical State
-Remove invalid input
Physical ZipPostal Code > Physical Zipcode
-Remove invalid zipcode
Company Website
-Remove invalid input

Mailing Street Address 1
Mailing Street Address 2
Mailing City
Mailing State
-Remove invalid input
Mailing Zipcode
-Remove invalid input

Rename:
Business Owner Name
Business Owner Office Phone
Business Owner Cell Phone
Business Owner Email
Main Point of Contact Name
Main Point of Contact Phone
Main Point of Contact Cell Phone
Main Point of Contact Email

BO Name
BO Office Phone
BO Cell Phone
BO Email
MPOC Name
MPOC Office Phone
MPOC Cell Phone
MPOC Email

Doing Business As > Business Type
Business Start Date > Date Business Founded

New Index (Not found in old access db)
State of Incorporation
Federal ID
Dunn & Bradstreet
Business License
Business License Expiration Date

vendor recruitment log renames to vlog
index repaired and organized
vendor requests rename to vreq
recruitment numbers renames to recruits

Repair Received Date Column for invlaid
Imported Employee Data
-Removed Company, Home Phone, Fax Number, Address, City, State/Province, zip/Postal, Country, Webpage, Attachment
-Add login, password, permission, status, lastlogin

Addressed duplicate usernames
salt/password all users completed.  Algorism for add/update/change password functional.
- Default user id is first initial and full last name all lowercase
- Default password is full lastname and 951 all lowercase

Permission base content implemented.
Developers 	- Debug Content/Full Access
Management 	- Full Access Vendors and Employees (Create/Read/Update/Delete)		:2 Test Management	ID: tmana	PWD: 123
Administration 	- Full Access Vendors (Create/Read/Update/Delete)			:3 Test Administration	ID: tadmin	PWD: 123
Recruitment 	- Limited Access Vendors (Create/Read/Update)				:4 Test Recruitment	ID: trec	PWD: 123
Employees 	- Limited Access Vendors (Read Only)					:5 Test Employee	ID: temp	PWD: 123

Added quick way to turn on/off active for employees.
 
Critical check on adding vendor.
-Only recruitment can add vendor.  All add function removed from active/banished.

Imported in the recruitment table completed

Add rule to hide php ext.
index
main
active
banish
employees
recruit

vendor (34columns) 10251 Records
Normalize vendor table for NOT NULL (Cannot be null on new record)
ID
Received_Date
Vendor Type
Company_Name
Physical_Street_Address_1
Physical_City
Physical_State
Physical_Zipcode
BO_Name
BO_Office_Phone
BO_Cell_Phone
geoservice
Latitude
Longitude

Remove from vendor table:
Preservation Vendor
Rehab Vendor
Inspection Vendor
Grass Cut Vendor
Speciality Vendor


UPDATE Employees Table
Implement photo upload for employees
SET foreign_key_checks = 0;
CREATE TABLE `Employees` (
   `EmployeeID`      MEDIUMINT UNSIGNED  NOT NULL AUTO_INCREMENT,
                     -- [0, 65535]
   `LastName`        VARCHAR(20)         NOT NULL,
   `FirstName`       VARCHAR(20)         NOT NULL,
   `Title`           VARCHAR(30),  					-- e.g., 'State Coordinator'
   `Role` 			 INT(10)			 NOT NULL,  -- e.g., 'Employee'
   `Status`       	 TINYINT(1)			 NOT NULL,
   `LoginName`       VARCHAR(20)         NOT NULL,
   `LoginPassword`   VARCHAR(128)        NOT NULL,
   `WorkEmail`       VARCHAR(45),
   `WorkPhone`       VARCHAR(24),
   `Extension`       VARCHAR(4),
   `Photo`           BLOB,                          -- 64KB
   `Notes`           TEXT,  						-- 64KB
   `ReportsTo`       MEDIUMINT UNSIGNED  NULL,  	-- Manager's ID
													-- Allow NULL for boss
   `Salt`       	 VARCHAR(128),
   `LastLogin`       DATETIME,						-- 'YYYY-MM-DD'
   INDEX (`LoginName`),
   INDEX (`LastName`),
   PRIMARY KEY (`EmployeeID`),
   FOREIGN KEY (`ReportsTo`) REFERENCES `Employees` (`EmployeeID`)
);
SET foreign_key_checks = 1;


Revamp layout for form consistency
All layout incorporate with theme
Session privacy added


12/27/2014
Revamp login interface and main index
Add vendor belong to user under employees
Forms added


Not present in Form:
ReceivedDate
USBest Representative
Vendor Status


Form Namings:
Step 1: Company Info

CoName
geocomplete (!autofill)
name (Address)
unit
locality (city)
administrative_area_level_1 (state)
postal_code
lat (hidden)
lng (hidden)
location (geocode #.####,#.#### hidden)
CoWebsite

maddress (!autofill)
mname
munit
mlocality
madministrative_area_level_1
mpostal_code
mlat (hidden)
mlng (hidden)
mlocation (geocode #.####,#.#### hidden)

BoName
BoPhone
BoCell
BoEmail
mpoc_name
mpoc_phone
mpoc_cell
mpoc_email

Step 2: Organization Info
OI_BClass
OI_BCOther
OI_DateFound (Date)
OI_StateInc (text delimeter ,)
OI_FedID
OI_Dunn
OI_License
OI_LicExp (Date)
OI_States (text delimeter ,)
OI_Counties (text delimeter ,)
OI_Primary
OI_PrimaryYears (int)
OI_Service
OI_ServiceYears (int)
OI_Other
OI_OtherYears (int)
OI_Specialties (text delimeter ,)
OI_OtherSp (text delimeter ,)
OI_LicByState (bool)
OI_StateLic
OI_Insurance (bool)
OI_InsAmount
OI_WorkerComp (bool)
OI_Photos (bool)
OI_Ysmart (bool)
OI_Bsmart (bool)

Step 3: Work Experience
WE_EmpAmnt
WE_Sub
WE_SubAmnt (number only)
WE_Current (number only)
WE_Month (number only)
WE_Year (number only)
WE_WInc (bool)
WE_WINote (text)
WE_Convict (bool)
WE_Bankrupt (bool)
WE_Court (bool)
WE_Claim (bool)
WE_Entity (bool)
WE_USBest (bool)
WE_Ref (text)

Step 4: Business Classification
BC_Class
BC_Other
BC_Agency
BC_CertNum
BC_ExpDate (date)


12/29/2014
Changes:
vendor > tblVendors
vstate > tblStates
vperm > tblRoles
-PermID > RoleID
vtype > tblVenStatus
-ID > StatusID
-VendorType > VendorStatus
Employees > tblEmployees

Update frontend to new employees table
Update Recruit/Active/Banish to new table


[tblVenInfo]
VendorID
OI_BClass
OI_BCOther
OI_DateFound (Date)
OI_StateInc (text delimeter ,)
OI_FedID
OI_Dunn
OI_License
OI_LicExp (Date)
OI_States (text delimeter ,)
OI_Counties (text delimeter ,)
OI_Primary
OI_PrimaryYears (int)
OI_Service
OI_ServiceYears (int)
OI_Other
OI_OtherYears (int)
OI_Specialties (text delimeter ,)
OI_OtherSp (text delimeter ,)
OI_LicByState (bool)
OI_StateLic
OI_Insurance (bool)
OI_InsAmount
OI_WorkerComp (bool)
OI_Photos (bool)
OI_Ysmart (bool)
OI_Bsmart (bool)
LastUpdated

[tblVenWorkExp]
VendorID
WE_EmpAmnt
WE_Sub
WE_SubAmnt (number only)
WE_Current (number only)
WE_Month (number only)
WE_Year (number only)
WE_WInc (bool)
WE_WINote (text)
WE_Convict (bool)
WE_Bankrupt (bool)
WE_Court (bool)
WE_Claim (bool)
WE_Entity (bool)
WE_USBest (bool)
WE_Ref (text)
LastUpdated

[tblVenBusiness]
VendorID
BC_Class
BC_Other
BC_Agency
BC_CertNum
BC_ExpDate (date)
LastUpdated

12/30/2014




Plan and todo:
Database Reindexing:
Recruitment log (2/4 Completion)
Vendor Requests (3/4 Completion)
Vendor Application (3/4 Completion)
Recruiment Number (4/4 Completion)
Employees (4/4 Completion)

Forms validation and link to backend for testing. (3 forms submission/change/request)
Frontend vendor view forms
Implement change approval by user before take effect.
Implement tracking of past changes.
Implement counties autofill



Global mapping of vendors
QC for vendors (Development)
