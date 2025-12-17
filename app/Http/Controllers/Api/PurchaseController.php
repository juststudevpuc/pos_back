<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{

    public function summaryPurchase()
    {
        // Current Month
        $startOfMonth = Carbon::now("UTC")->startOfMonth();
        $endOfMonth = Carbon::now("UTC")->endOfMonth();

        $purchaseThisMonth = Purchase::query()->whereBetween("created_at", [$startOfMonth, $endOfMonth])->get();

        // Current Year
        $startOfYear = Carbon::now("UTC")->startOfYear();
        $endOfYear = Carbon::now("UTC")->endOfYear();

        $summaryPurchaseByMonth = Purchase::raw(function ($collection) use ($startOfYear, $endOfYear) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'created_at' => [
                            '$gte' => new \MongoDB\BSON\UTCDateTime($startOfYear),
                            '$lte' => new \MongoDB\BSON\UTCDateTime($endOfYear),
                        ]
                    ]
                ],
                [
                    '$group' => [
                        '_id' => [
                            'month' => ['$month' => '$created_at'], // 11,12
                            'year' => ['$year' => '$created_at'] // 2025
                        ],
                        'total' => ['$sum' => ['$toDouble' => '$paid']]
                    ]
                ],
                ['$sort' => ['_id.month' => 1]],
                [
                    '$project' => [
                        'title' => [
                            '$dateToString' => [
                                'format' => '%b', // Nov, Dec
                                'date' => [
                                    '$dateFromParts' => [
                                        'month' => '$_id.month',
                                        'year' => '$_id.year',
                                        'day' => 1,
                                    ]
                                ]
                            ]
                        ],
                        'total' => 1,
                        '_id' => 0
                    ]
                ]
            ]);
        });

        return response()->json([
            "purchase_this_month" => $purchaseThisMonth,
            "summary_purchase_by_month" => $summaryPurchaseByMonth,
            "message" => "Get summary purchase successfully."
        ], 200);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchase = Purchase::with(["purchaseProduct.product", "supplier"])->get();

        return response()->json([
            "data" => $purchase,
            "message" => "Get purchase successfully."
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "shipping_cost" => "required|string|max:255",
            "paid" => "required|string|max:255",
            "paid_date" => "required|string|max:255",
            "supplier_id" => "required|string|exists:suppliers,_id",
            "purchase_product" => "required|array"
        ]);

        // create purchase
        $purchase = Purchase::create([
            "shipping_cost" => $request->shipping_cost,
            "paid" => $request->paid,
            "paid_date" => $request->paid_date,
            "supplier_id" => $request->supplier_id,
        ]);

        // create purchase product
        if ($purchase) {
            foreach ($request->purchase_product as $item) {
                $purchase->purchaseProduct()->create([
                    "qty" => $item["qty"],
                    "retail_price" => $item["retail_price"],
                    "cost" => $item["cost"],
                    "ref" => $item["ref"],
                    "remark" => $item["remark"],
                    "product_id" => $item["product_id"],
                ]);
            }
        }

        return response()->json([
            "data" => $purchase->load(["purchaseProduct.product", "supplier"]),
            "message" => "Created purchase successfully."
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $purchase = Purchase::find($id);

        if (!$purchase) {
            return response()->json([
                "message" => "Purchase isn't found."
            ], 404);
        }

        return response()->json([
            "data" =>  $purchase->load(["purchaseProduct.product", "supplier"]),
            "message" => "Get one purchase successfully."
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $purchase = Purchase::find($id);

        if (!$purchase) {
            return response()->json([
                "message" => "Purchase isn't found."
            ], 404);
        }

        $request->validate([
            "shipping_cost" => "required|string|max:255",
            "paid" => "required|string|max:255",
            "paid_date" => "required|string|max:255",
            "supplier_id" => "required|string|exists:suppliers,_id",
            "purchase_product" => "required|array"
        ]);

        // create purchase
        $purchase->update([
            "shipping_cost" => $request->shipping_cost,
            "paid" => $request->paid,
            "paid_date" => $request->paid_date,
            "supplier_id" => $request->supplier_id,
        ]);

        // Remove old purchase product
        $purchase->purchaseProduct()->delete();

        // create new purchase product
        if ($purchase) {
            foreach ($request->purchase_product as $item) {
                $purchase->purchaseProduct()->create([
                    "qty" => $item["qty"],
                    "retail_price" => $item["retail_price"],
                    "cost" => $item["cost"],
                    "ref" => $item["ref"],
                    "remark" => $item["remark"],
                    "product_id" => $item["product_id"],
                ]);
            }
        }

        return response()->json([
            "data" => $purchase->load(["purchaseProduct.product", "supplier"]),
            "message" => "Updated purchase successfully."
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $purchase = Purchase::find($id);

        if (!$purchase) {
            return response()->json([
                "message" => "Purchase isn't found."
            ], 404);
        }

        // delelte purchase
        $purchase->delete();

        // delete  purchase product
        $purchase->purchaseProduct()->delete();

        return response()->json([
            "data" => $purchase->load(["purchaseProduct.product", "supplier"]),
            "message" => "Deleted purchase successfully."
        ], 200);
    }
}
