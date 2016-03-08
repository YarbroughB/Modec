# About Project Modec

Project Modec is school project in which we will attempt to create a very user
friendly Modularly Extendable Core using Zend Framework 2 (ZF2).

We choose ZF2 for this because it is already built around the idea of using
modules; however, many modules designed for ZF2 are more standalone and
separated from each other. This means that one module may have no knowledge of
the other modules around it. This can lead to multiple modules reimplementing
their own versions of basic elements such as admin cps, navigation, user
accounts, etc. These separate implementations lead to a disconnect that may
confuse users and makes the entire system harder to use.

Our project will differ from this design in that our modules will be
specifically designed and tested to work with our core and each other. Our core
will be designed to implement the basic elements, so that our modules can be
built with the knowledge that they will have access to them. These basic
elements will be designed in a way that each module will have the ability to
extend them as needed. Eventually, our modules will also be designed in a way
that they can extend the functionality of other modules when present (for
example a gallery module that extends the cms module to add a widget to
highlight a random gallery).

# Planned Features / Modules

 * Core
	* User Accounts
		* ~~User Registration~~
			* ~~Human Verification~~
			* Email Validation
		* ~~User Authentication~~
		* Admin CP
			* Add Users
			* Edit Users
			* Moderate / Ban Users	* Access Control List		* Usergroup Based
		* Admin CP
			* Edit Permissions for Resources	* ~~Database Driven Navigation~~
		* Admin CP
			* Add Navigation Links
			* Edit Navigation Links
			* Disable Navigation Links
	* Database Driven Routes
		* Admin CP
			* Add Routes
			* Edit Routes
			* Disable Routes
	* Database Driven Settings	* Admin CP
 * Content Management System
 * Blog
 * Photo Gallery
