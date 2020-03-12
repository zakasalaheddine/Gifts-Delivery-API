# GIFT Delivery API

GIFT Delivery is an ecommerce platform that helps people send gifts to their beloved ones using web/mobile application solutions.

## END POINTS:

### Add new city
```sh
POST > /api/cities 
Body: name => String|Required
```
### Add new Delivery Time or 

```sh
POST > /api/delivery-times | Body: name
Body: delivery_at => String|Required
```
### Attach Delivery Time or Delivery Times to a City
```sh
POST > /api/cities/{city}/delivery-times 
Param: city => City ID
Body: delivery_time => Integer|Optional
Body: delivery_times => Array|Optional
```
### Exclude from delivery times on a City
```sh
POST > /api/cities/{city}/exclude-date
Param: city => City ID
Body: date => Date|Required|Format:d-m-yy
example : 12-03-2020
Body: delivery_time => Integer|Required
```
### Get all delivery times possible in a city for selected number of days
```sh
GET > /api/cities/{city}/delivery-dates-times/{days}
Param: city => City ID
Param: days => Number of days to check
Body: date => Date|Required
Body: delivery_time => Integer|Required
```
