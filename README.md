# Character-Cafe
Online cafe that offers food and beverages for sale, emulates the checkout process, and allows managers to add, modify, and remove items. WAMP software stack utilized with WampServer web development environment.
___

## Online Cafe Web App
This cafe offers food that appears in video games, using the real-life versions of those recipes. Inspiration was drawn from Capcom Cafe, a small Capcom-themed character cafe located in Tokyo:
```
http://www.capcom.co.jp/amusement/capcomcafe/
```
Character cafes are popular types of themed cafes that collaborate with popular characters, games, anime, movies, etc. These cafes usually offer limited edition food and drinks. Some are permanent cafes with fixed themes, while others are pop-up cafes or have changing themes.
The first iteration of this character cafe focused on Genshin Impact, a video game developed and published by miHoYo:
```
https://genshin.hoyoverse.com/en/home
```
Food can be used to heal characters, revive characters, buff the player's character, or buff the entire party.
The game features a cooking system via a minigame that allows players to craft consumable items that can be used to heal, revive, or buff characters in the player's party. Due to the game's popularity, there are many amazing real-life dishes that have been made by fans of the game.

### Services and instructions:
- Customers can view the menu on the site without an account, but they must have an account and be logged in to order food.
  ```
  customer login info: 
      - username: test
      - password: test
  ```
- Managers must log in using a different account through a separate login portal, which takes them to an internal page where they can then add, modify, and remove food items, as well as view the all of the food items order details available in the database.
  ```
  manager login info: 
      - username: test
      - password: test
  ```
- Once you log in as a manager, a dashboard will be displayed instead of the cart in the navbar. Managers are still able to view the home, menu, and merch pages.
Example: Instructions to add a food item (managers will be redirected to the menu page upon sucessful entry to see results)
  ```
  name: Wolfhook Juice
  description: A freshly squeezed, fashionable, and fruity non-alcoholic beverage.
  price: 7.00
  image path: images/food/Wolfhook_Juice
  available: yes
  ```
___

### Uncompleted features/services:
- Merchandise Ordering: While the website was originally intended to be an online store exclusively for merchandise, I decided on a food ordering service to showcase the amazing real-life creations of the in-game food and held off on the merch store.
- Account page: Planned to implement a customer account page where users can save their favorite food items and edit reservations.
- Bootstrap modal login form to show a pop-up login form when logging in from the navbar: Using AJAX to submit and handle the data. The ability to update data without reloading the page would have allowed a pop-up menu that would open up in index.php and send data to a separate authentication page to validate inputs. It would also have removed the need for two separate "action" pages for the Add Food and Remove Food options for managers.
- Although I added the ability to remove food items from the menu, I didn't add the option to add it back in. I need to add something to the Remove Food or Edit Food pages to allow for this. 
___

### Closing thoughts and project details: 
- Considering user-centered design and the importance of "mobile-first," I wanted to make sure that my web app was responsive with mobile devices in mind. For this reason, I used Bootstrap. The design for the website was inspired by a Bootstrap template for a restaurant:
  ```
  https://html.design/preview/?theme=live_dinner
  ```
  Other sections of the web app like the checkout form and the login/register pages were taken from examples online. 
  ```
  https://getbootstrap.com/docs/4.5/examples/checkout/
  https://bootsnipp.com/snippets/X2GOr
  ```
- Escaping quotations marks in PHP for sticky form inputs: If inputting a name with an apostrophe using the following code, the apostrophe and everything after it would not be shown because the quotation mark in the php code interfered and closed the input using the apostrophe from the name as the ending single quotation mark. 
  ```
  <?php if(isset($fullname)) echo "value='$fullname'"; ?> 
  ```
  Resolved the issue by using the following code instead: 
  ```
  value="<?php if(isset($fullname)) echo $fullname; ?>"
  ```
