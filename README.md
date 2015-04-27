CloudKeeper
===

We aim to bring the power of cloud computing and analytics to a local shop vendor so as to improve his/her business right through mobile.

Status :
==
* Working Shops, Invoice and Item addition/display
* Functioning login system

Todo : 
==
* Validations at PHP and JS sides
* Update operations
* [x] Delete operations
* Simpler and quicker forms 
* Auto-fill enteries based on past/filled details
* Search
* Add MySQL Triggers for invoice and item updates
  - [x] After insert on invoice_details, update owner_items.quantity for each cart item
  - [x] After insert on invoice_details, update invoices.invoice_amount
* Create MySQL Queries for great analytics such as 
  - Least/Most Sold Product
  - Least/Most Profitable Product
  - Peak/Crest Points for each Product
  - Total Profit/Revenue 
  - Projections for next duration
  - Demand and Supply of Products
  - Predict quantity 
  - Least/Most Profitable Shop
* Use knob.js / highcharts etc to show above data
* Search Engine for products 
* Compare Prices of products from different vendors
