CloudKeeper
===
We aim to bring the power of cloud computing and analytics to a local shop vendor so as to improve his/her business right through mobile.
![Product Image 1](/screenshots/1.png)
Problem Statement
===
Data is backbone of any successful business, no matter how big or small it is. While big corporate companies rely on mainframe computers for all their data entries and analyze it using complex systems, a shopkeeper on other hand maintains his register with all daily logs in it.

With the advent of Internet revolution and cheap smartphones, a low end shopkeeper can finally afford an efficient system than those registers, which not only are difficult to maintain, but also make analyzing the data nearly impossible.

We, here are maintaining a database for a shopkeeper and providing it as a web service, so that:

- Data entry and maintenance becomes less cumbersome.
- Searching or 'Querying' for particular entries or stock items becomes user friendly and faster.
- Analysis can be done for him by the web service, suggesting him better ways to sell, order, market or invest in his products.
- The shopkeeper can easily maintain his records of items available in his shops, items he sold and the profit or loss earned.
- He can easily analyze the market growth of the products and on the basis of demand and sales from his shops, he can calculate the money to be invested in his shop and many more benefits can be achieved.
- Eventually his business grows and even then the web service can scale up, thanks to presence of efficient database systems.

Screenshots
===========
* Dashboard

![Product Image 2](/screenshots/2.png)
* Mobile View

![Product Image 3](/screenshots/3.png)

Todo  
===
* ***Future*** : Compare Prices of products from different vendors
* ***Future*** : Auto-fill enteries based on past/filled details
* ***Future*** : Predictions, this is bought with this, wallmart-ish!
* ***Future*** : Tips to maximize profit
* ***Future*** : Edit invoice
* Filter by period
* Add tabs for invoices by shops 
* Better filters on analytics, flexible durations
* Better explanation of the tool on front page
* Find more FDs, state them rightly
* [x] Create MySQL Queries for great analytics such as 
  - [x] Area graph for revenue / profit for give range (weeks, months, years)
  - [x] Peak/Crest Points for each Product vs Revenue
  - [x] Peak/Crest Points for each Product vs Profit
  - [x] Least/Most Sold Product
  - [x] Least/Most Profitable Product
  - [x] Peak/Crest Points for each Product vs Quantity
  - [x] Total Revenue 
  - [x] Total Profit 
  - [x] Least/Most Profitable Shop
* [x] Add MySQL Triggers for invoice and item updates
  - [x] After insert on invoice_details, update owner_items.quantity for each cart item
  - [x] After insert on invoice_details, update invoices.invoice_amount
* [x] Search shops/items/invoices
* [x] Search Engine for products 
* [x] Phone numbers
* [x] Edit profile
* [x] Show more of invoice in overview
* [x] Bug with analytics : Shows stuff even when no invoices are there
* [x] Validations at PHP and JS sides
* [x] SQL procedure getOwnerId(invoiceId)
* [x] Refactor SQL analytics queries
* [x] Add From Items Database
* [x] Invoice details 
* [x] Use string escaping for mysql queries
* [x] Update operations
* [x] Delete operations
* [x] Profile
* [x] Use knob.js / highcharts etc to show above data
* [x] Working Shops, Invoice and Item addition/display
* [x] Functioning login system

Potential Issues 
==
* Deleting an item would affect all the related invoices, which is weird. Although deleting an item would imply that such item was accidently added or is now discontinued. 
* Deleting a shop would affect all invoices. Need to give a "backup" feature.
