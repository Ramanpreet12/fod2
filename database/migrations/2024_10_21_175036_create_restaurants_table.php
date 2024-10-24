<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->enum('role', ['restaurant_owner'])->default('restaurant_owner');                        // Restaurant role
            $table->string('name');                         // Restaurant Name
            $table->text('description');                    // Restaurant Description
            $table->string('speciality');                     // Cuisine speciality
            // $table->string('category');                     // Cuisine Category
            $table->string('logo')->nullable();             // Restaurant Logo
            $table->text('address');                      // Restaurant Address
            $table->string('city');                         // City
            $table->string('state')->nullable();            // State
            $table->string('postal_code');                  // Postal Code
            $table->string('country');                      // Country
            $table->decimal('latitude', 10, 7)->nullable(); // Geo-Coordinates: Latitude
            $table->decimal('longitude', 10, 7)->nullable();// Geo-Coordinates: Longitude
            $table->integer('delivery_radius')->nullable(); // Delivery Radius in km
            $table->string('phone');                        // Phone Number
            $table->string('secondary_phone')->nullable();  // Secondary Phone
            $table->string('email')->unique();              // Restaurant Email
            $table->string('password')->unique()->nullable();              // Restaurant auto generated password
            $table->string('website')->nullable();          // Restaurant Website
            $table->string('opening_time');                   // Opening Time
            $table->string('closing_time');                   // Closing Time
            $table->string('days_of_operation');              // Days of Operation
            $table->string('owner_name');                   // Owner Name
            $table->string('owner_contact_number');         // Owner Contact Number
            $table->string('owner_email')->unique();        // Owner Email
            // $table->string('menu_categories')->nullable();  // Menu Categories
            // $table->string('menu_file')->nullable();        // Menu File (PDF/Image)
            // $table->string('menu_url')->nullable();         // Menu URL (optional)
            $table->decimal('average_cost_for_per_person', 8, 2)->nullable();  // Average Cost for one
            // $table->decimal('service_charge', 8, 2)->nullable(); // Service Charge (if any)
            // $table->string('discounts_or_offers')->nullable();   // Discounts or Offers
            // $table->string('restaurant_type');              // Restaurant Type (Dine-in/Takeaway/Delivery)
            // $table->integer('seating_capacity')->nullable();// Seating Capacity (if any)
            // $table->boolean('accepting_online_orders')->default(true); // Accepting Online Orders
            // $table->boolean('vegetarian_options')->default(false);     // Vegetarian/Vegan Options Available
            // $table->boolean('alcohol_served')->default(false);         // Alcohol Served
            // $table->boolean('halal')->default(false);                  // Halal/Kosher
            // $table->string('delivery_partner')->nullable();            // Delivery Partner Integration
            // $table->decimal('min_order_amount', 8, 2)->nullable();     // Minimum Order Amount
            $table->decimal('delivery_fee', 8, 2)->nullable();         // Delivery Fee
            $table->string('delivery_time')->nullable();               // Estimated Delivery Time
            $table->string('restaurant_images')->nullable();                      // Restaurant Images
            $table->string('featured_image')->nullable();              // Featured Image
            // $table->json('payment_methods')->nullable();               // Accepted Payment Methods
            // $table->string('bank_details')->nullable();                // Bank Details (for payouts)
            $table->enum('status', ['active', 'inactive'])->default('active'); // Restaurant Status
            $table->boolean('featured')->default(false);               // Featured Status
            $table->string('tax_gst_number')->nullable();                      // Tax ID/GST Number
            $table->string('business_license')->nullable();            // Business License Number
            // $table->text('special_instructions')->nullable();          // Special Instructions (optional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};