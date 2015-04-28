--- Most sold
Select item_id, myCount FROM (Select item_id,count(*) as myCount
    FROM `invoices` natural join `invoice_items` natural join `shops`where owner_id = 1 GROUP BY `item_id`) as t1 limit 5;

--- Least sold
Select item_id, min(myCount) FROM (Select item_id,count(*) as myCount
    FROM `invoices` natural join `invoice_items` natural join `shops`where owner_id = 1 GROUP BY `item_id`) as t1;

--- Most profitable 
SELECT g.item_id,g.w FROM (Select owner_id,owner_items.item_id,sum(price-cost_price)*invoice_items.quantity as w, price FROM `owner_items` ,`invoice_items` WHERE owner_items.item_id = invoice_items.item_id group by owner_items.item_id) as g limit 5;

--- Least profitable
SELECT g.item_id,min(g.w) FROM (Select owner_id,owner_items.item_id,sum(price-cost_price)*invoice_items.quantity as w, price FROM `owner_items` ,`invoice_items` WHERE owner_items.item_id = invoice_items.item_id group by owner_items.item_id) as g;

--- Total Revenue
Select sum((invoice_items.price-owner_items.cost_price)*invoice_items.quantity) From `invoice_items`, `owner_items` WHERE invoice_items.item_id = owner_items.item_id and `owner_id`=1;

--- Peak and crest time
Select item_id,DATE(invoice_time) From `invoice_items`, `invoices` WHERE invoices.invoice_id = invoice_items.invoice_id and shop_id IN (SELECT shop_id FROM `shops` natural join `owner` where owner_id = 1);

--- Shop wise Total revenue
Select shop_id, sum((price-cost_price)*invoice_items.quantity) From `invoice_items`, `invoices`, `owner_items` WHERE invoices.invoice_id = invoice_items.invoice_id and invoice_items.item_id = owner_items.item_id and shop_id IN (SELECT shop_id FROM `shops` natural join `owner` where owner_id = 1) group by shop_id; 