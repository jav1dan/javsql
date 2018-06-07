# javsql
Lightweight PHP Class For safe and easy Mysql Connecting
Class is using mysqli interface.
## Start
For using javsql you should, at first, initialize it.
```php
$sql=new JavSQL();
```
## Connecting to MYSQL SERVER
Then, you should set each parametres for connecting.
You can set each parametr
```php
$sql->setDBName('test');
$sql->setDBUser('test');
$sql->setDBPassword('test');
$sql->setDBServer('localhost');
```
Also you can specify parametres as an array
```php
$params=array(
'host'=>'localhost',
'user'=>'test',
'pass'=>'test',
'name'=>'test'
);
$sql->setDBParams($params);
```
For connecting, you should use Connect function. It return TRUE if connection is successfull and FALSE if not.
```php
$val=$sql->Connect();
```
## Functions
### setDBPrefix
JavSql also can determine prefix for all your names of tables.
```php
$sql->setDBPrefix('db_');
```
### getDBPrefix
You can also get DB Prefix
```php
$prefix=$sql->getDBPrefix();
```

### IsConnected
IsConnected function is using for determine if javsql connected to mysql server or not.
```php
$check=$sql->isConnected();
```
### getRowsCount
Function getRowsCount allows you to get count of specified raws in mysql table.
As arguments this function gets `table_name` and `determination`
For example, we have table `users`, with such columns as `id`,`name`,`password`.

|id|name|password|
|---|---|---|
|1|user1|qwerty|
|2|user2|qwerty|
|3|user3|123456|

And we want to get count of users with password `qwerty`.
For that case we should type:
```php
$count=$sql->getRowsCount('users',"`password`='qwerty'");
echo $count;
```
As a result, script will print `2`.

### rawQuery
Function rawQuery allows you to query any script to mysql server.
Return `true` if success and `false` if not;
For example:
```php
$sql->rawQuery('SET NAMES utf8');
```
### addQuery
Function addQuery is using for adding row to mysql table.
As arguments you should determine `table_name` and array with columns and their values.
For example, lets add to our `users` table row with new user, which name is `user4` and `password` is 'qwerty' and `id`='4'
```php
$vars=array(
'id'=>'4',
'name'='user4',
'password'='qwerty');
$sql->addQuery('users',$vars);
```
### updateQuery
Function updateQuery is using for updating row in mysql table.
As arguments you should determine `table_name`,array with columns and their values and determination for `where`.
For example, let update row in table `users` and change `qwerty` in `password` column to `qwerqwe` for user with `id`='3';
```php
$vars=array('password'=>'qwerqwe');
$sql->updateQuery('users',$vars,"`id`='3'");
```
### getRows
Function getRows is using for getting rows from table.
As arguments you should determine `table_name`, you can specify `columns`,determination for `where` and determination for `order`;
For example, let get all rows from our `users` table.
```php
$rows=$sql->getRows('users');
```
As a result we will get array with all rows in table.
If you want to specify some parametres, you should user`where` argument.
For example, let get all rows from our `users` table with `password`='qwerty'
```php
$rows=$sql->getRows('users','',"`password`='qwerty'");
```
Also you can determine what columns you want to select.
For example, you want to select all rows but without `id` column.
```php
$rows=$sql->getRows('users','`name`,`password`');
```
### getRawRows
Function getRawRows is using for getting all rows from table with specified query.
For example, we have such query:
```sql
SELECT `id`,`name` FROM `users` WHERE `password`='qwerty' ORDER BY `name` ASC;
```
Lets get fetched array with result of this query:
```php
$rows=$sql->getRawRows("SELECT `id`,`name` FROM `users` WHERE `password`='qwerty' ORDER BY `name` ASC");
```

