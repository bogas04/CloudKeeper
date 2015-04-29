CloudKeeper
===

We aim to bring the power of cloud computing and analytics to a local shop vendor so as to improve his/her business right through mobile.

Status 
==
* Working Shops, Invoice and Item addition/display
* Functioning login system

Todo  
==
* Validations at PHP and JS sides
* Use string escaping for mysql queries
* Update operations
* [x] Delete operations
* [x] Profile
* Auto-fill enteries based on past/filled details
* Search shops/ items/ invoices
* Invoice details 
* Add MySQL Triggers for invoice and item updates
  - [x] After insert on invoice_details, update owner_items.quantity for each cart item
  - [x] After insert on invoice_details, update invoices.invoice_amount
* Create MySQL Queries for great analytics such as 
  - [x] Least/Most Sold Product
  - [x] Least/Most Profitable Product
  - [x] Peak/Crest Points for each Product
  - [x] Total Revenue 
  - [x] Total Profit 
  - Projections for next duration
  - Predict quantity 
  - [x] Least/Most Profitable Shop
* [x] Use knob.js / highcharts etc to show above data
* Future : Search Engine for products 
* Future : Compare Prices of products from different vendors

Potential Issues 
==
* Deleting an item would affect all the related invoices, which is weird. Although deleting an item would imply that such item was accidently added or is now discontinued. 
* Deleting a shop would affect all invoices. Need to give a "backup" feature.
