<?php
if (!isset($cartHandlerIncluded)) {
    $cartHandlerIncluded = true;
    include 'cart_handler.php'; // Ensure this logic executes only once
}
?>



<div style="text-align: center; margin: 20px;">
    <h2>Explore Our Toys</h2>
    <p>Browse through our exciting collection of toys for all ages!</p>
</div>

<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin: 20px;">

    <!-- Toy 1 -->
    <div style="border: 1px solid #ccc; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); background-color: #f9f9f9; transition: transform 0.2s, box-shadow 0.2s;"
         onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 4px 10px rgba(0, 0, 0, 0.2)';"
         onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 2px 5px rgba(0, 0, 0, 0.1)';">
        <div style="background-color: red; color: white; padding: 5px 10px; position: absolute; top: 10px; left: 10px; border-radius: 4px; font-size: 12px;">Sale</div>
        <img src="uploads/bb.jpg" alt="Bouncy Ball" style="width: 100%; height: auto; border-radius: 8px;">
        <h4>Bouncy Ball</h4>
        <h7>was: 299.00 PHP</h7>
        <p>Now: 199.00 PHP</p>
        <form method="post" action="">
    <input type="hidden" name="toy_id" value="5"> <!-- Toy ID -->
    <button type="submit" name="add_to_cart" button style="padding: 8px 15px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">Add to Cart</button></form>
    </div>

    <!-- Toy 2 -->
    <div style="border: 1px solid #ccc; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); background-color: #f9f9f9; transition: transform 0.2s, box-shadow 0.2s;"
         onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 4px 10px rgba(0, 0, 0, 0.2)';"
         onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 2px 5px rgba(0, 0, 0, 0.1)';">
        <img src="uploads/blocks.jpg" alt="Mega Construction Blocks" style="width: 100%; height: auto; border-radius: 8px;">
        <h4>Mega Construction Blocks</h4>
        <p>Price: 999.00 PHP</p>
        <form method="post" action="">
        <input type="hidden" name="toy_id" value="6"> <!-- Toy ID -->
    <button type="submit" name="add_to_cart" button style="padding: 8px 15px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">Add to Cart</button></form>
    </div>

    <!-- Toy 3 -->
    <div style="border: 1px solid #ccc; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); background-color: #f9f9f9; transition: transform 0.2s, box-shadow 0.2s;"
         onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 4px 10px rgba(0, 0, 0, 0.2)';"
         onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 2px 5px rgba(0, 0, 0, 0.1)';">
        <img src="uploads/space.jpg" alt="Space Explorer Set" style="width: 100%; height: auto; border-radius: 8px;">
        <h4>Space Explorer Set</h4>
        <p>Price: 2399.00 PHP</p>
        <form method="post" action="">
        <input type="hidden" name="toy_id" value="7"> <!-- Toy ID -->
    <button type="submit" name="add_to_cart" button style="padding: 8px 15px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">Add to Cart</button></form>
    </div>

    <!-- Toy 4 -->
    <div style="border: 1px solid #ccc; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); background-color: #f9f9f9; transition: transform 0.2s, box-shadow 0.2s;"
         onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 4px 10px rgba(0, 0, 0, 0.2)';"
         onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 2px 5px rgba(0, 0, 0, 0.1)';">
        <img src="uploads/slime.jpg" alt="Super Slime Kit" style="width: 100%; height: auto; border-radius: 8px;">
        <h4>Super Slime Kit</h4>
        <p>Price: 350.00 PHP</p>
        <form method="post" action="">
        <input type="hidden" name="toy_id" value="8"> <!-- Toy ID -->
    <button type="submit" name="add_to_cart" button style="padding: 8px 15px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">Add to Cart</button></form>
    </div>

    <!-- Toy 5 -->
    <div style="border: 1px solid #ccc; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); background-color: #f9f9f9; transition: transform 0.2s, box-shadow 0.2s;"
         onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 4px 10px rgba(0, 0, 0, 0.2)';"
         onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 2px 5px rgba(0, 0, 0, 0.1)';">
        <img src="uploads/doll.jpg" alt="Dollhouse with Furniture" style="width: 100%; height: auto; border-radius: 8px;">
        <h4>Dollhouse with Furniture</h4>
        <p>Price: 2599.00 PHP</p>
        <form method="post" action="">
        <input type="hidden" name="toy_id" value="9"> <!-- Toy ID -->
    <button type="submit" name="add_to_cart" button style="padding: 8px 15px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">Add to Cart</button></form>
    </div>

    <!-- Toy 6 -->
    <div style="border: 1px solid #ccc; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); background-color: #f9f9f9; transition: transform 0.2s, box-shadow 0.2s;"
         onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 4px 10px rgba(0, 0, 0, 0.2)';"
         onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 2px 5px rgba(0, 0, 0, 0.1)';">
        <img src="uploads/uni.jpg" alt="Interactive Plush Unicorn" style="width: 100%; height: auto; border-radius: 8px;">
        <h4>Interactive Plush Unicorn</h4>
        <p>Price: 1499.00 PHP</p>
        <form method="post" action="">
        <input type="hidden" name="toy_id" value="10"> <!-- Toy ID -->
    <button type="submit" name="add_to_cart" button style="padding: 8px 15px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">Add to Cart</button></form>
    </div>

    <div style="border: 1px solid #ccc; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); background-color: #f9f9f9; transition: transform 0.2s, box-shadow 0.2s;" 
         onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 4px 10px rgba(0, 0, 0, 0.2)';"
         onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 2px 5px rgba(0, 0, 0, 0.1)';">
        <div style="background-color: red; color: white; padding: 5px 10px; position: absolute; top: 10px; left: 10px; border-radius: 4px; font-size: 12px;">Sale</div>
        <img src="uploads/ak.jpg" alt="Adventure Kit" style="width: 100%; height: auto; border-radius: 8px;">
        <h4>Adventure Kit</h4>
        <h7>was: 500.00 PHP</h7>
        <p>Now: 350.00 PHP</p>
        <form method="post" action="">
        <input type="hidden" name="toy_id" value="11"> <!-- Toy ID -->
    <button type="submit" name="add_to_cart" button style="padding: 8px 15px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">Add to Cart</button></form>
    </div>

    <div style="border: 1px solid #ccc; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); background-color: #f9f9f9; transition: transform 0.2s, box-shadow 0.2s;" 
         onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 4px 10px rgba(0, 0, 0, 0.2)';"
         onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 2px 5px rgba(0, 0, 0, 0.1)';">
        <div style="background-color: red; color: white; padding: 5px 10px; position: absolute; top: 10px; left: 10px; border-radius: 4px; font-size: 12px;">Sale</div>
        <img src="uploads/animal.jpg" alt="Animal Kingdom" style="width: 100%; height: auto; border-radius: 8px;">
        <h4>Animal Kingdom</h4>
        <h7>was: 759.00 PHP</h7>
        <p>Now: 599.00 PHP</p>
        <form method="post" action="">
        <input type="hidden" name="toy_id" value="12"> <!-- Toy ID -->
    <button type="submit" name="add_to_cart" button style="padding: 8px 15px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">Add to Cart</button></form>
    </div>

    

</div>
