# TIJN
Simple Wallet application

## Install
1. Clone the repository to your apache web server
2. Use same configuration for setting up directories as a normal symfony project
3. Run `composer install`
4. Create database `TIJN`
5. Create the tables

## Database Design
### USERS

| Field        | Type        | Null | Key | Default | Extra          |
|--------------|-------------|------|-----|---------|----------------|
| USER_ID      | int(10)     | NO   | PRI | NULL    | auto_increment |
| PLAN_ID      | int(10)     | YES  | MUL | NULL    |                |
| FIRST_NAME   | varchar(40) | YES  |     | NULL    |                |
| LAST_NAME    | varchar(40) | YES  |     | NULL    |                |
| SSN          | int(11)     | YES  |     | NULL    |                |
| BALANCE      | float       | YES  |     | 0       |                |
| IS_CONFIRMED | char(1)     | YES  |     | NULL    |                |

### PLAN

| Field                 | Type    | Null | Key | Default | Extra          |
|-----------------------|---------|------|-----|---------|----------------|
| PLAN_ID               | int(10) | NO   | PRI | NULL    | auto_increment |
| WEEKLY_TRANSFER_LIMIT | float   | YES  |     | NULL    |                |
| SINGLE_TRANSFER_LIMIT | float   | YES  |     | NULL    |                |
| WEEKLY_PAYMENT_LIMIT  | float   | YES  |     | NULL    |                |

### BANK_ACCOUNT

| Field          | Type        | Null | Key | Default | Extra          |
|----------------|-------------|------|-----|---------|----------------|
| BANK_ID        | int(10)     | NO   | PRI | NULL    | auto_increment |
| ACCOUNT_NUMBER | varchar(25) | NO   | PRI | NULL    |                |
| USER_ID        | int(10)     | NO   | PRI | NULL    |                |
| IS_PRIMARY     | char(1)     | YES  |     | NULL    |                |
| IS_VERIFIED    | char(1)     | YES  |     | NULL    |                |

### SEND_PAYMENT

| Field        | Type        | Null | Key | Default           | Extra                       |
|--------------|-------------|------|-----|-------------------|-----------------------------|
| PAYMENT_ID   | int(10)     | NO   | PRI | NULL              | auto_increment              |
| TO_USERID    | int(10)     | YES  | MUL | NULL              |                             |
| FROM_USERID  | int(10)     | YES  | MUL | NULL              |                             |
| PAYMENT_TIME | timestamp   | NO   |     | CURRENT_TIMESTAMP | on update CURRENT_TIMESTAMP |
| AMOUNT       | int(20)     | YES  |     | NULL              |                             |
| MEMO         | varchar(30) | YES  |     | NULL              |                             |
| IS_CANCELLED | char(1)     | YES  |     | NULL              |                             |

### REQUEST_PAYMENT

| Field        | Type        | Null | Key | Default           | Extra                       |
|--------------|-------------|------|-----|-------------------|-----------------------------|
| REQUEST_ID   | int(10)     | NO   | PRI | NULL              | auto_increment              |
| FROM_USERID  | int(10)     | YES  | MUL | NULL              |                             |
| TO_USERID    | int(10)     | YES  | MUL | NULL              |                             |
| REQUEST_TIME | timestamp   | NO   |     | CURRENT_TIMESTAMP | on update CURRENT_TIMESTAMP |
| AMOUNT       | int(20)     | YES  |     | NULL              |                             |
| MEMO         | varchar(30) | YES  |     | NULL              |                             |
| COMPLETED    | char(1)     | YES  |     | N                 |                             |


### TOKEN

| Field             | Type        | Null | Key | Default | Extra          |
|-------------------|-------------|------|-----|---------|----------------|
| TOKEN_ID          | int(10)     | NO   | PRI | NULL    | auto_increment |
| USER_ID           | int(10)     | YES  | MUL | NULL    |                |
| TOKEN_TYPE        | int(10)     | YES  |     | NULL    |                |
| EMAIL             | varchar(50) | YES  |     | NULL    |                |
| PHONE             | varchar(13) | YES  |     | NULL    |                |
| IS_VERIFIED_TOKEN | char(1)     | YES  |     | NULL    |                |
| PASSWORD          | varchar(40) | YES  |     | NULL    |                |



