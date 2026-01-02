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
        Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Связь с юзером
        $table->string('status')->default('new'); // new, processing, completed, cancelled
        $table->decimal('total_price', 10, 2); // Итоговая сумма
        $table->string('address'); // Адрес доставки
        $table->string('phone');   // Телефон
        $table->text('comment')->nullable(); // Комментарий
        $table->timestamps();
        });

        // Таблица ТОВАРОВ В ЗАКАЗЕ
        Schema::create('order_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
        $table->foreignId('product_id')->constrained('products'); // Какой товар
        $table->integer('quantity'); // Сколько штук
        $table->decimal('price', 10, 2); // Цена НА МОМЕНТ ПОКУПКИ (важно!)
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_items');
        Schema::dropIfExists('orders');
    }
};
