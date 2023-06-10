<?php
namespace App\services\services;

use App\Models\Tag;
use App\Models\Tax;
use App\Models\Product;
use App\Models\Advantage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Storage;
use App\services\contracts\ProductContract;

class ProductService implements ProductContract
{
    public function __construct(ProductRepository $ProductRepository)
    {
        $this->ProductRepository = $ProductRepository;
    }

    public function create($request)
    {
        // print_r($request->all());exit;
        DB::beginTransaction();

        $request->validate([
            'name' => 'required',
            'name_en' => 'required',
            'price' => 'required|numeric',
        ]);

        $input = $request->all();
        if ($request->file('avatar')) {
            $avatar = $request->file('avatar');
            $avatar->store('uploads/products/', 'public');
            $input['avatar'] = $avatar->hashName();
        } else {
            $input['avatar'] = null;
        }
        $Product = new Product();
        $this->ProductRepository->create($input);

        $tags = json_decode($request->post('tags'));
        $tags_en = json_decode($request->post('tags_en'));
        if (isset($tags) && isset($tags_en)) {
            if (count($tags) !== count($tags_en)) {
                return redirect()
                    ->back()
                    ->withErrors([
                        'message' => trans('error.count_tag'),
                    ])
                    ->withInput();
            }

            for ($i = 0; $i < count($tags); $i++) {
                $tag = Tag::create([
                    'name' => [
                        'en' => $tags_en[$i]->value,
                        'ar' => $tags[$i]->value,
                    ],
                ]);
                $Product->tags()->attach($tag);
            }
        }

        $advantages = $request->kt_docs_repeater_basic;

        foreach ($advantages as $advantage) {
            if (
                $advantage['advantage'] == null &&
                $advantage['advantage_en'] == null
            ) {
                return redirect()
                    ->back()
                    ->withErrors([
                        'message' => trans('error.advantage'),
                    ])
                    ->withInput();
            } else {
                $newAdvantage = new Advantage();
                $newAdvantage->uuid = Str::uuid();
                $newAdvantage->advantage = [
                    'en' => $advantage['advantage_en'],
                    'ar' => $advantage['advantage'],
                ];
                $newAdvantage->desc_advantage = [
                    'en' => $advantage['desc_advantage_en'],
                    'ar' => $advantage['desc_advantage'],
                ];

                $newAdvantage->product_id = $Product->id;
                $newAdvantage->save();
            }
        }

        DB::commit();
        session()->flash('success', 'Data Added Successfully');

        return redirect()->route('dashboard.products.index');
    }
    public function update($request, $product)
    {
        DB::beginTransaction();
        try {
            $input = $request->except(
                'tags',
                'tags_en',
                'kt_docs_repeater_basic'
            );

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                Storage::disk('public')->delete(
                    'uploads/products/' . $product->avatar
                );
                $request->avatar->store('uploads/products/', 'public');
                $input['avatar'] = $avatar->hashName();
            } else {
                $input['avatar'] = $product->avatar;
            }
            if ($request->is_applied_tax) {
                $product->is_applied_tax = true;
            } else {
                $product->is_applied_tax = false;
            }
            $product->update([
                'avatar' => $input['avatar'],
                'name' => [
                    'en' => $input['name_en'],
                    'ar' => $input['name'],
                ],
                'desc' => [
                    'en' => $input['desc_en'],
                    'ar' => $input['desc'],
                ],
                'descLong' => [
                    'en' => $input['descLong_en'],
                    'ar' => $input['descLong'],
                ],
                'price_new' => $input['price_new'],
            ]);

            $tags = json_decode($request->post('tags'));
            $tags_en = json_decode($request->post('tags_en'));
            $tag_ids = [];
            $saved_tags = Tag::all();
            if (count($tags) !== count($tags_en)) {
                return redirect()
                    ->back()
                    ->withErrors([
                        'message' => trans('error.count_tag'),
                    ])
                    ->withInput();
            }

            for ($i = 0; $i < count($tags); $i++) {
                $tag = $saved_tags->where('name', $tags[$i]->value)->first();

                if (!$tag) {
                    $tag = Tag::create([
                        'name' => [
                            'en' => $tags_en[$i]->value,
                            'ar' => $tags[$i]->value,
                        ],
                    ]);
                }
                $tag_ids[] = $tag->id;
            }
            $product->tags()->attach($tag_ids);

            $advantages = $request->kt_docs_repeater_basic;

            if (isset($advantages)) {
                foreach ($advantages as $key => $advantage) {
                    $order = $product->advantages()->updateOrCreate(
                        ['uuid' => $advantage['uuid']],
                        [
                            'advantage' => [
                                'en' => $advantage['advantage_en'],
                                'ar' => $advantage['advantage'],
                            ],
                            'desc_advantage' => [
                                'en' => $advantage['desc_advantage_en'],
                                'ar' => $advantage['desc_advantage'],
                            ],
                            'uuid' => Str::uuid(),
                        ]
                    );
                }
            }

            DB::commit();
            session()->flash('success', 'Data Updated Successfully');

            return redirect()->route('dashboard.products.edit', [$product->id]);
        } catch (\Throwable $th) {
            // print_r($th->getMessage());
            // print_r($th->getLine());
            // exit();
            DB::rollBack();
            throw $th;
        }
    }
    public function delete($product)
    {
        $product->delete();
        session()->flash('success', 'Data Deleted Successfully');
        return redirect()->route('dashboard.products.index');
    }
}