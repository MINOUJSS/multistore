<?php

namespace App\Services\Users\Sellers;

use App\Models\Seller\SellerProductAttributes;
use App\Models\Seller\SellerProductVariations;

class Seller_Cart
{
    public $items = [];
    public $free_shipping;
    public $totalQty;
    public $totalPrice;

    public function __construct($cart = null)
    {
        if ($cart) {
            $this->items = $cart->items;
            $this->free_shipping = $cart->free_shipping;
            $this->totalQty = $cart->totalQty;
            $this->totalPrice = $cart->totalPrice;
        } else {
            $this->items = [];
            $this->free_shipping = 'yes';
            $this->totalQty = 0;
            $this->totalPrice = 0;
        }
    }

    public function add($product, $variation_id = 0, $attribute_id = 0)
    {
        $price = get_seller_product_price($product->id);

        // get free shipping
        if (is_free_shipping($product->id)) {
            $free_shipping = 'yes';
        } else {
            $free_shipping = 'no';
        }

        $qty = request()->quantity;

        $item = [
            'id' => $product->id,
            'title' => $product->name,
            'price' => $price,
            'variation_ids' => [0 => ['id' => 0, 'qty' => 0, 'variation' => []]],
            'attribute_ids' => [0 => ['id' => 0, 'qty' => 0, 'attribute' => []]],
            'free_shipping' => $free_shipping,
            'qty' => 0,
            'image' => $product->image,
        ];
        // $item = [
        //     'id' => $product->id,
        //     'title' => $product->name,
        //     'price' => $price,
        //     'variation_ids' => [],
        //     'attribute_ids' => [],
        //     'free_shipping' => $free_shipping,
        //     'qty' => 0,
        //     'image' => $product->image,
        // ];

        // get additional price
        $aditional_price = 0;
        if ($attribute_id != 0) {
            $attribute = SellerProductAttributes::find($attribute_id);
            if ($attribute) {
                $aditional_price = $attribute->additional_price * $qty;
            }
        }

        // إذا كان هذا المنتج غير موجود بالسلة
        if (!array_key_exists($product->id, $this->items)) {
            // أضف المنتج للسلة
            $this->items[$product->id] = $item;
            // عدل على الكمية و السعر الإجمالي
            if ($qty) {
                $this->totalQty += $qty;
                $this->totalPrice += ($price * $qty) + $aditional_price;
            } else {
                ++$this->totalQty;
                $this->totalPrice += $price;
            }
            // check free shipping
            if ($item['free_shipping'] == 'no') {
                $this->free_shipping = 'no';
            }

            // $v_qty = $this->items[$product->id]['variation_ids'][0]['qty'] ?? 0;
            // $att_qty = $this->items[$product->id]['attribute_ids'][0]['qty'] ?? 0;
            // إذكان المنتج يحتوي على متغييرات مثل الألوان و الحجم ...إلخ أضفها
            if (($variation_id != 0 && $attribute_id ==0) || ($variation_id != 0 && $attribute_id !=0)) {
                // get variation data
                $variations = SellerProductVariations::find($variation_id);
                $variation = $variations ? $variations : [];
                $this->items[$product->id]['variation_ids'][$variation_id] = ['id' => $variation_id, 'qty' => $qty, 'variation' =>is_array($variation) ? $variation : $variation->toArray()];
               
            } else {
                $this->items[$product->id]['variation_ids'][0] = ['id' => 0, 'qty' => 0, 'variation' => []];
            } 
            // إذا كان المنتج يحتوي على خصايص مثل الماركة ...إلخ أضفها
            if (($attribute_id != 0 && $variation_id==0) || ($variation_id != 0 && $attribute_id !=0)) {
                // get attribute data
                $attributes = SellerProductAttributes::find($attribute_id);
                $attribute = $attributes ? $attributes : [];
                $this->items[$product->id]['attribute_ids'][$attribute_id] = ['id' => $attribute_id, 'qty' => $qty, 'attribute' =>is_array($attribute)? $attribute : $attribute->toArray()];
            } else {
                $this->items[$product->id]['attribute_ids'][0] = ['id' => 0, 'qty' => 0, 'attribute' => []];
            }
            // عدل على الكمية الفرعية الإفتراضية
            if ($variation_id == 0 && $attribute_id == 0) {
                $this->items[$product->id]['variation_ids'][0]['qty'] += $qty;
                $this->items[$product->id]['attribute_ids'][0]['qty'] += $qty;
            }
        } else {
            // إذا كان هذا المنتج موجود بالسلة عدل على الكمية و السعر الإجمالي
            if ($qty) {
                $this->totalQty += $qty;
                $this->totalPrice += ($price * $qty) + $aditional_price;
            } else {
                ++$this->totalQty;
                $this->totalPrice += $price;
            }
            // عدل على الكمية الفرعية الإفتراضية
            if ($variation_id == null && $attribute_id == null) {
                $this->items[$product->id]['variation_ids'][0]['qty'] += $qty;
                $this->items[$product->id]['attribute_ids'][0]['qty'] += $qty;
            }
            // // إذا كان هذا المنتج موجود بالسلة عدل على الكمية و السعر الإجمالي
            // if ($qty) {
            //     $this->totalQty += $qty;
            //     $this->totalPrice += $price * $qty;
            // } else {
            //     ++$this->totalQty;
            //     $this->totalPrice += $price;
            // }

            // $v_qty = $this->items[$product->id]['variation_ids'][0]['qty'];
            // $att_qty = $this->items[$product->id]['attribute_ids'][0]['qty'];

            if (($variation_id != null) && !array_key_exists($variation_id, $this->items[$product->id]['variation_ids'])) {
                // get variation data
                $variations = SellerProductVariations::find($variation_id);
                $variation = $variations ? $variations : [];
                // dd($variation->ToArray());
                $this->items[$product->id]['variation_ids'][$variation_id] = ['id' => $variation_id, 'qty' => $qty, 'variation' => is_array($variation) ? $variation : $variation->toArray()];
            } else {
                // dd($variation_id,$attribute_id);
                // variation null and attribute null
                if ($variation_id == null && $attribute_id == null) {
                    $this->items[$product->id]['variation_ids'][0]['qty'] = ++$this->items[$product->id]['variation_ids'][0]['qty'];
                }
                // variation not null and attribute null
                if ($variation_id != null && $attribute_id == null) {
                    $this->items[$product->id]['variation_ids'][$variation_id]['qty'] = ++$this->items[$product->id]['variation_ids'][$variation_id]['qty'];
                }
                // variation not null and attribute not null
                if ($variation_id != null && $attribute_id != null) {
                    $this->items[$product->id]['variation_ids'][$variation_id]['qty'] = ++$this->items[$product->id]['variation_ids'][$variation_id]['qty'];
                }
                // variation null and attribute not null
                // if ($variation_id == null && $attribute_id != null) {
                //     dd('hi');
                //     $this->items[$product->id]['attribute_ids'][$attribute_id]['qty'] = ++$this->items[$product->id]['attribute_ids'][$attribute_id]['qty'];
                // }
                // dd($this->items[$product->id]['variation_ids'][$variation_id]);
                // if ($variation_id == null && $attribute_id == null) {
                //     $this->items[$product->id]['variation_ids'][0]['qty'] = ++$this->items[$product->id]['variation_ids'][0]['qty'];
                // } elseif($variation_id != null) {
                //     $this->items[$product->id]['variation_ids'][$variation_id]['qty'] = ++$this->items[$product->id]['variation_ids'][$variation_id]['qty'];
                // }
            }
            if (($attribute_id != null || $attribute_id != 0) && !array_key_exists($attribute_id, $this->items[$product->id]['attribute_ids'])) {
                // get attribute data
                $attributes = SellerProductAttributes::find($attribute_id);
                $attribute = $attributes ? $attributes : [];
                $this->items[$product->id]['attribute_ids'][$attribute_id] = ['id' => $attribute_id, 'qty' => ++$this->items[$product->id]['attribute_ids'][$attribute_id]['qty'], 'attribute' => is_array($attribute) ? $attribute : $attribute->toArray()];
            } else {
                // variation null and attribute null
                if ($variation_id == null && $attribute_id == null) {
                    $this->items[$product->id]['attribute_ids'][0]['qty'] = ++$this->items[$product->id]['attribute_ids'][0]['qty'];
                }
                // variation not null and attribute null
                if ($variation_id != null && $attribute_id == null) {
                    $this->items[$product->id]['attribute_ids'][0]['qty'] = ++$this->items[$product->id]['attribute_ids'][0]['qty'];
                }
                // variation not null and attribute not null
                if ($variation_id != null && $attribute_id != null) {
                    $this->items[$product->id]['attribute_ids'][$attribute_id]['qty'] = ++$this->items[$product->id]['attribute_ids'][$attribute_id]['qty'];
                }
                // variation null and attribute not null
                if ($variation_id == null && $attribute_id != null) {
                    $this->items[$product->id]['attribute_ids'][$attribute_id]['qty'] = $this->items[$product->id]['attribute_ids'][$attribute_id]['qty'] + $qty;
                }

                // dd($variation_id, $attribute_id, 1);
                // if ($attribute_id == null && $variation_id == null) {
                //     $this->items[$product->id]['attribute_ids'][0]['qty'] = ++$this->items[$product->id]['attribute_ids'][0]['qty'];
                // } elseif ($attribute_id != null) {
                //     $this->items[$product->id]['attribute_ids'][$attribute_id]['qty'] = ++$this->items[$product->id]['attribute_ids'][$attribute_id]['qty'];
                // }
            }
            // dd($price,$qty,$this->totalQty,$this->totalPrice);
        }

        if ($qty) {
            $this->items[$product->id]['qty'] += $qty;
        } else {
            ++$this->items[$product->id]['qty'];
        }

        // test
        // add color if it is not null
        //   $variation=SellerProductVariations::find(request()->variation_id);
        //   if($variation)
        //   {
        //   $color=$variation->color;
        //   if($color)
        //   {
        //      $this->items[$product->id]['color']=$color;
        //   }
        //   //add size if it is not null
        //   $size=$variation->size;
        //   if($size)
        //   {
        //      $this->items[$product->id]['size']=$size;
        //   }
        //   //add wieght if it is not null
        //   $weight=$variation->weight;
        //   if($weight)
        //   {
        //      $this->items[$product->id]['weight']=$weight;
        //   }
        // }
    }

    //   public function addWithQty($product,$qty,$color_id,$size_id)
    //   {
    //     if(has_discount($product->id))
    //     {
    //       $price=price_with_discount($product->id);
    //     }
    //     else
    //     {
    //       $price=$product->selling_price;
    //     }

    //     $item=[
    //         'id' =>$product->id,
    //         'title' =>$product->name,
    //         'price' =>$price,
    //         'color_id' =>0,
    //         'size_id' =>0,
    //         'qty' =>0,
    //         'image' =>$product->image
    //     ];
    //     if(!array_key_exists($product->id,$this->items))
    //     {
    //         $this->items[$product->id]=$item;
    //         $this->totalQty += $qty;
    //         $this->totalPrice += $price * $qty;
    //     }
    //     else
    //     {
    //         $this->totalQty +=$qty;
    //         $this->totalPrice+=$price * $qty;
    //     }

    //         $this->items[$product->id]['qty'] +=$qty;
    //         $this->items[$product->id]['color_id'] =$color_id;
    //         $this->items[$product->id]['size_id'] =$size_id;

    //   }

    public function remove($id)
    {
        if (array_key_exists($id, $this->items)) {
            // get additional price
            foreach ($this->items[$id]['variation_ids'] as $variation) {
                if (!empty($variation['variation'])) {
                    $this->totalPrice -= $variation['qty'] * $variation['variation']['additional_price'];
                }
            }
            $this->totalQty -= $this->items[$id]['qty'];
            $this->totalPrice -= $this->items[$id]['qty'] * $this->items[$id]['price'];
            unset($this->items[$id]);
            // inistialize free shipping
            $this->free_shipping = 'yes';
            // check if the items has anly free shipping
            foreach ($this->items as $item) {
                if ($item['free_shipping'] == 'no') {
                    $this->free_shipping = 'no';
                }
            }
        }
    }

    // function remove all cart items
    public function removeAll()
    {
        foreach ($this->items as $item) {
            $this->remove($item['id']);
        }
    }

    //  public function remove_variation($id,$variation_id,$attribute_id)
    // {
    //  // dd($this->items[$id]['variation_ids'][$variation_id]['qty'] * $this->items[$id]['variation_ids'][$variation_id]['variation']['additional_price']);
    //     if(array_key_exists($id,$this->items) && array_key_exists($variation_id,$this->items[$id]['variation_ids']) && array_key_exists($attribute_id,$this->items[$id]['attribute_ids']))
    //     {
    //       if($variation_id!=0 && $attribute_id!=0)
    //       {
    //         $this->totalPrice -= ($this->items[$id]['price'] +$this->items[$id]['variation_ids'][$variation_id]['variation']['additional_price']) * $this->items[$id]['variation_ids'][$variation_id]['qty'];
    //       }
    //       else
    //       {
    //       $this->totalPrice -= $this->items[$id]['price'] * $this->items[$id]['variation_ids'][$variation_id]['qty'];
    //       }
    //       $this->items[$id]['qty'] -=$this->items[$id]['variation_ids'][$variation_id]['qty'];
    //       $this->totalQty -=$this->items[$id]['variation_ids'][$variation_id]['qty'];
    //       unset($this->items[$id]['variation_ids'][$variation_id]);
    //       unset($this->items[$id]['attribute_ids'][$attribute_id]);
    //     }
    // }

    public function remove_variation($id, $variation_id, $attribute_id)
    {
        // التحقق من وجود المنتج والتنويعات والخصائص في السلة
        if (!array_key_exists($id, $this->items)
            || !array_key_exists($variation_id, $this->items[$id]['variation_ids'])
            || !array_key_exists($attribute_id, $this->items[$id]['attribute_ids'])) {
            return false; // أو يمكن رمي استثناء إذا لزم الأمر
        }

        // حساب الكمية والسعر للإزالة
        // if (!empty($this->items[$id]['variation_ids'])) {
        if ($this->items[$id]['variation_ids'][$variation_id]['qty'] != 0 && $this->items[$id]['attribute_ids'][$attribute_id]['qty'] != 0) {
            $variation = $this->items[$id]['variation_ids'][$variation_id];
            $attribute = $this->items[$id]['attribute_ids'][$attribute_id];
            if ($variation['qty'] == 0) {
                $quantityToRemove = $attribute['qty'];
            } else {
                $quantityToRemove = $variation['qty'];
            }
            // حساب السعر الإجمالي للإزالة (يشمل السعر الأساسي + أي سعر إضافي للتنويعات)
            $priceToRemove = $this->items[$id]['price'];
            // if ($variation_id != 0 && !empty($variation['variation']['additional_price'])) {
            //     $priceToRemove += $variation['variation']['additional_price'];
            // }
            if ($attribute_id != 0 && !empty($attribute['attribute']['additional_price'])) {
                $priceToRemove += $attribute['attribute']['additional_price'];
            }

            $totalPriceToRemove = $priceToRemove * $quantityToRemove;
            // dd($this->items[$id]['attribute_ids'][$attribute_id]);
            // تحديث السلة
            $this->totalQty -= $quantityToRemove;
            $this->totalPrice -= $totalPriceToRemove;
            $this->items[$id]['qty'] -= $quantityToRemove;

            // إزالة التنويعات والخصائص
            unset($this->items[$id]['variation_ids'][$variation_id]);
            unset($this->items[$id]['attribute_ids'][$attribute_id]);
            // renisialization
            $this->items[$id]['variation_ids'][$variation_id] = ['id' => 0, 'qty' => 0, 'variation' => []];
            $this->items[$id]['attribute_ids'][$attribute_id] = ['id' => 0, 'qty' => 0, 'attribute' => []];

            // dd($this->items[$id]['attribute_ids']);

            // if (empty($this->items[$id]['variation_ids']) && !empty($this->items[$id]['attribute_ids']) && $this->items[$id]['attribute_ids'][0]['qty'] == 0) {
            //     $this->items[$id]['qty'] == 0;
            // }

            if ($this->items[$id]['qty'] == 0) {
                unset($this->items[$id]);
            }
            //
            // dd($this->items[$id]);
            // if(empty($this->items))
            // {
            //     $this->free_shipping='yes';
            //     $this->totalQty=0;
            //     $this->totalPrice=0;
            // }
            // inistialize free shipping
            $this->free_shipping = 'yes';
            // check if the items has anly free shipping
            foreach ($this->items as $item) {
                if ($item['free_shipping'] == 'no') {
                    $this->free_shipping = 'no';
                }
            }
        } else {
            if ($attribute_id != 0) {
                //additional_price
                $additional_price = $this->items[$id]['attribute_ids'][$attribute_id]['attribute']['additional_price'];
                $item_qty = $this->items[$id]['attribute_ids'][$attribute_id]['qty'];
                $totaladditional_price = $additional_price * $item_qty;
                $this->totalQty -= $this->items[$id]['qty'];
                $this->totalPrice -= ($this->items[$id]['price'] * $this->items[$id]['qty'])+$totaladditional_price;
            } else {
                $this->totalQty -= $this->items[$id]['qty'];
                $this->totalPrice -= $this->items[$id]['price'] * $this->items[$id]['qty'];
            }

            unset($this->items[$id]);
            // inistialize free shipping
            $this->free_shipping = 'yes';
            // check if the items has anly free shipping
            foreach ($this->items as $item) {
                if ($item['free_shipping'] == 'no') {
                    $this->free_shipping = 'no';
                }
            }
        }

        // // إذا لم يعد هناك تنويعات للمنتج، يمكن إزالته تمامًا من السلة
        // if (empty($this->items[$id]['variation_ids'])) {
        //     unset($this->items[$id]);
        // }

        return true;
    }

    //   public function updateQty($id,$qty,$color_id,$size_id)
    //   {
    //     //reset the totalprice and totalqty in the cart
    //     $this->totalQty-=$this->items[$id]['qty'];
    //     $this->totalPrice-=$this->items[$id]['price'] * $this->items[$id]['qty'];
    //     //new qty of item
    //     $this->items[$id]['qty']=$qty;
    //     $this->items[$id]['color_id']=$color_id;
    //     $this->items[$id]['size_id']=$size_id;

    //     //new totalprice and totalqty in the cart
    //     $this->totalQty+=$this->items[$id]['qty'];
    //     $this->totalPrice+=$this->items[$id]['price'] * $this->items[$id]['qty'];

    //   }

    /**
     * Increment quantity of a cart item.
     *
     * @param int $id           Product ID
     * @param int $variation_id Variation ID (optional)
     * @param int $attribute_id Attribute ID (optional)
     * @param int $qty          Quantity to increment (default 1)
     */
    public function increment($id, $variation_id = null, $attribute_id = null, $qty = 1)
    {
        if (!array_key_exists($id, $this->items)) {
            return false;
        }

        $product = $this->items[$id];
        $price = $product['price'];

        // Handle variation additional price if exists
        if ($variation_id && isset($product['variation_ids'][$variation_id])) {
            $variation = $product['variation_ids'][$variation_id];
            if (!empty($variation['variation']['additional_price'])) {
                $price += $variation['variation']['additional_price'];
            }
            $this->items[$id]['variation_ids'][$variation_id]['qty'] += $qty;
        }

        // Update main quantities
        $this->items[$id]['qty'] += $qty;
        $this->totalQty += $qty;
        $this->totalPrice += $price * $qty;

        return true;
    }

    /**
     * Decrement quantity of a cart item.
     *
     * @param int $id           Product ID
     * @param int $variation_id Variation ID (optional)
     * @param int $attribute_id Attribute ID (optional)
     * @param int $qty          Quantity to decrement (default 1)
     *
     * @return bool Returns false if quantity would go below 1
     */
    public function decrement($id, $variation_id = null, $attribute_id = null, $qty = 1)
    {
        if (!array_key_exists($id, $this->items)) {
            return false;
        }

        // Check if decrement would make quantity zero or negative
        if ($this->items[$id]['qty'] <= $qty) {
            return false;
        }

        $product = $this->items[$id];
        $price = $product['price'];

        // Handle variation additional price if exists
        if ($variation_id && isset($product['variation_ids'][$variation_id])) {
            $variation = $product['variation_ids'][$variation_id];
            if (!empty($variation['variation']['additional_price'])) {
                $price += $variation['variation']['additional_price'];
            }

            // Check variation quantity
            if ($this->items[$id]['variation_ids'][$variation_id]['qty'] <= $qty) {
                return false;
            }

            $this->items[$id]['variation_ids'][$variation_id]['qty'] -= $qty;
        }

        // Update main quantities
        $this->items[$id]['qty'] -= $qty;
        $this->totalQty -= $qty;
        $this->totalPrice -= $price * $qty;

        return true;
    }

    /**
     * Update quantity of a cart item.
     *
     * @param int      $id           Product ID
     * @param int      $newQty       New quantity
     * @param int|null $variation_id Variation ID
     * @param int|null $attribute_id Attribute ID
     */
    public function updateQty($id, $newQty, $variation_id = 0, $attribute_id = 0)
    {
        if (!array_key_exists($id, $this->items) || $newQty < 1) {
            return false;
        }

        $product = $this->items[$id];
        $price = $product['price'];
        $oldQty = $product['qty'];
        $oldvaritionQty = $product['variation_ids'][$variation_id]['qty'];
        $oldattributeQty = $product['attribute_ids'][$attribute_id]['qty'];

        // Handle variation additional price if exists
        // if ($variation_id!=0 && isset($product['variation_ids'][$variation_id])) {
        $attribute = $product['attribute_ids'][$attribute_id];
        if (!empty($attribute['attribute']['additional_price'])) {
            $price += $attribute['attribute']['additional_price'];
        }

        // Calculate difference for variation
        $QtyDiff = $newQty - $oldQty;
        $variationQtyDiff = $newQty - $oldvaritionQty;
        $attributeQtyDiff = $newQty - $oldattributeQty;
        // if($variation_id==0 || $attribute_id==0)

        // normal
        if ($variation_id == 0 && $attribute_id == 0) {
            $this->items[$id]['variation_ids'][$variation_id]['qty'] += $QtyDiff;
            $this->items[$id]['attribute_ids'][$attribute_id]['qty'] += $QtyDiff;
        }
        // color only
        if ($variation_id != 0 && $attribute_id == 0) {
            $this->items[$id]['variation_ids'][$variation_id]['qty'] += $QtyDiff;
        }
        // attribute only
        if ($variation_id == 0 && $attribute_id != 0) {
            $this->items[$id]['attribute_ids'][$attribute_id]['qty'] += $QtyDiff;
        }
        // has color and attribute
        if ($variation_id != 0 && $attribute_id != 0) {
            $this->items[$id]['variation_ids'][$variation_id]['qty'] += $QtyDiff;
            $this->items[$id]['attribute_ids'][$attribute_id]['qty'] += $QtyDiff;
        }

        // //the original code below
        // $this->items[$id]['variation_ids'][$variation_id]['qty'] += $QtyDiff;
        // $this->items[$id]['attribute_ids'][$attribute_id]['qty'] += $QtyDiff;

        // }

        // Update main quantities
        // $qtyDiff = $newQty - $oldQty;
        // $this->items[$id]['qty'] = $newQty;
        // $this->items[$id]['qty'] = $this->items[$id]['variation_ids'][$variation_id]['qty'] + $this->items[$id]['attribute_ids'][$attribute_id]['qty'];
        $this->items[$id]['qty'] += $QtyDiff;
        // $this->totalQty += $qtyDiff;
        $this->totalQty += $QtyDiff;
        // $this->totalPrice += $price * $qtyDiff;
        $this->totalPrice += $price * $QtyDiff;

        return true;
    }

    // public function updateQuantity(Request $request)
    // {
    //     $productId = $request->product_id;
    //     $variationId = $request->variation_id ?: null;
    //     $attributeId = $request->attribute_id ?: null;
    //     $newQuantity = $request->new_quantity;

    //     $cart = session()->get('cart');

    //     if ($cart) {
    //         // Update the quantity using the method we added to the Cart class
    //         $success = $cart->updateQty($productId, $newQuantity, $variationId, $attributeId);

    //         if ($success) {
    //             session()->put('cart', $cart);
    //             return response()->json([
    //                 'success' => true,
    //                 'cart' => [
    //                     'totalQty' => $cart->totalQty,
    //                     'totalPrice' => $cart->totalPrice
    //                 ]
    //             ]);
    //         }
    //     }

    //     return response()->json([
    //         'success' => false,
    //         'message' => 'فشل تحديث الكمية'
    //     ]);
    // }
}
