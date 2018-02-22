REST API with a simple UI
=====
v1.0

Features
---
* PHP Slim Backend
* HTML/JQuery FRONT

Summary
---
REST API has two methods sumandcheck and check. The first one returns the sum of the given numbers and 
true if the sum is a prime number or not. The second just returns the prime check.  

Basic Usage
---

1. Run composer on the /rest/ directory to install Slim framework: composer install
2. Create .env file in the root directory and write the following line USER_PASS=secr3t (You can change the password if you like)
3. Write the same password to the JQuery Client myapi.js located in the /js/ folder

``` javascript
var client = new $.RestClient('http://localhost/myapi/rest/', {
  username: 'restuser@example.com',
  password: '' // add your password here.
});
```

4. Open browser and go to the url http://localhost/myapi/

The simple UI provides a text field where you can enter the numbers. Then you must choose which method to call by selecting the radio buttons.
After submission the result from the API is shown above the form. If you like you can also call the API by entering the needed parameters to the url
like this.

http://localhost/myapi/?action=sumandcheck&numbers=1,2,3
http://localhost/myapi/?action=checkprime&number=12345

Summary
---
In real world there is always some kind of authentication when dealing with the REST or other API:s. In this example there is a lightweight HTTP Basic Authentication 
which is not a ideal thing. You should replace it with more robust and secure one like Oauth2 or some TOKEN based authentication. There is also no database or other
type of data storage included. 

