<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Throwable;

class CategoryController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $allCategory = Category::orderBy( 'created_at', 'desc' )->paginate( 5 );
        return response()->json( ['categories' => $allCategory], 200 );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        $validator = Validator::make( $request->all(), [
            'name'   => 'required|unique:categories,name',
            'image'  => 'required|image|mimes:jpeg,png,jpg|max:3072',
            'status' => 'required',
        ], [
            'name.required'   => 'Please insert category name!',
            'name.unique'     => 'This category name exist in our database.Please insert a unique category name!',
            'image.required'  => 'Please upload category image!',
            'image.mimes'     => 'Category image type should be jpeg,png,jpg!',
            'image.image'     => 'Please upload a valid image!',
            'image.max'       => 'Category image must be under 3 MB!',
            'status.required' => 'Please insert category status!',
        ] );
        // return $request->image;

        if ( $validator->fails() ) {
            $jsonData = [
                'errors'  => $validator->errors(),
                'success' => false,
            ];
            return response()->json( $jsonData, 422 );
        }
        try {

            // start image configuration
            $imglink        = $request->file( 'image' ); //main img link
            $image_name     = Str::slug( $request->name );
            $image_exe      = strtolower( $imglink->getClientOriginalExtension() );
            $image_fullName = $image_name . date( 'YmdHi' ) . '.' . $image_exe;
            // end image configuration

            // name lowercase start
            $catName = Str::lower( $request->name );
            // name lowercase end
            $insert         = New Category();
            $insert->name   = $catName;
            $insert->status = $request->status;
            $insert->image  = $image_fullName;
            $saveData       = $insert->save();

            if ( $saveData ) {
                //if data save then image will be upload
                Image::make( $imglink )->resize( 200, 200 )->save( public_path( 'storage/category_images/' ) . $image_fullName );
                $jsonData = [
                    'succMsg' => "Category successfully added!",
                    'success' => true,
                ];
                return response()->json( $jsonData, 200 );
            }

        } catch ( Throwable $th ) {
            $jsonData = [
                'errorMsg' => "Category didn't added for some technical issue!",
                'success'  => false,
                'error'    => $th,
            ];
            return response()->json( $jsonData, 500 );
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id ) {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id ) {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $id ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id ) {

        $findId = Category::findOrFail( $id );
        $Img    = $findId->image;

        if ( $findId->delete() ) {
            if ( file_exists( public_path( 'storage/category_images/' . $Img ) ) ) {
                unlink( public_path( 'storage/category_images/' . $Img ) );
            }
        }
        $jsonData = [
            'msg'     => 'Category Successfully Deleted!',
            'success' => true,
        ];
        return response()->json( $jsonData, 200 );
    }
}
