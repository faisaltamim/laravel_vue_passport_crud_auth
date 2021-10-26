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

    public function index() {
        $allCategory = Category::orderBy( 'created_at', 'desc' )->paginate( 5 );
        return response()->json( ['categories' => $allCategory], 200 );
    }

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
            $image_fullName = $image_name . date( 'd_m_Y_h_i_s_' ) . '.' . $image_exe; //time er ei 'd_m_Y_h_i_s_' format ta dile bar bar image update dile update image ta show korbe all data er oikhane ar onno format dile show korbe na tai ei format ta dite hobe always..ek kothay image upload hole ei format ta diyei update korte hobe
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

    public function update( Request $request, $id ) {

        $validator = Validator::make( $request->all(), [
            'name'   => 'required|unique:categories,name,' . $id,
            'image'  => 'nullable|image|mimes:jpeg,png,jpg|max:3072', //ei nullable ta dile update e image na dile problem nai but image up dewar por baki validation gula korbe jemon size er format er etc..
            'status' => 'required',
        ], [
            'name.required'   => 'Please insert category name!',
            'name.unique'     => 'This category name exist in our database.Please insert a unique category name!',
            'image.mimes'     => 'Category image type should be jpeg,png,jpg!',
            'image.image'     => 'Please upload a valid image!',
            'image.max'       => 'Category image must be under 3 MB!',
            'status.required' => 'Please insert category status!',
        ] );

        //validation message condition

        if ( $validator->fails() ) {
            $jsonData = [
                'message' => $validator->errors(),
                'success' => false,
            ];
            return response()->json( $jsonData, 422 );
        }

        // update user data by try catch
        try {
            $catName = Str::lower( $request->name );
            //update user data
            $update         = Category::findOrFail( $id );
            $oldImageFind   = $update->image;
            $update->name   = $catName;
            $update->status = $request->status;
            if ( $request->hasFile( 'image' ) ) {
                // first unlink old image
                if ( file_exists( public_path( 'storage/category_images/' . $oldImageFind ) ) ) {
                    unlink( public_path( 'storage/category_images/' . $oldImageFind ) );
                }

                // start image configuration
                $imglink        = $request->file( 'image' ); //main img link
                $image_name     = Str::slug( $request->name );
                $image_exe      = strtolower( $imglink->getClientOriginalExtension() );
                $image_fullName = $image_name . date( 'd_m_Y_h_i_s_' ) . '.' . $image_exe; //time er ei 'd_m_Y_h_i_s_' format ta dile bar bar image update dile update image ta show korbe all data er oikhane ar onno format dile show korbe na tai ei format ta dite hobe always..ek kothay image upload hole ei format ta diyei update korte hobe
                // end image configuration

                // if image upload then update
                $update->image = $image_fullName;

                //delete old image

                Image::make( $imglink )->resize( 200, 200 )->save( public_path( 'storage/category_images/' ) . $image_fullName );
            } else {
                // jehetu image e nullable condition dewa ache tai eikhane old image upload na dileo hobe
            }
            $updateData = $update->save();

            if ( $updateData ) {
                $jsonData = [
                    'message' => 'Category Successfully Updated!',
                    'success' => true,
                ];
                return response()->json( $jsonData, 200 );
            }
        } catch ( Throwable $th ) {
            $jsonData = [
                'message' => 'Category Did Not Updated!',
                'success' => false,
                'error'   => $th,
            ];
            return response()->json( $jsonData, 500 );
        }

    }

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

    public function deleteAll( $selected ) {

        $singleDelete = explode( ',', $selected );
        $totalData    = 0;

        foreach ( $singleDelete as $item ) {
            $findId = Category::findOrFail( $item );
            $Img    = $findId->image;

            if ( $findId->delete() ) {
                if ( file_exists( public_path( 'storage/category_images/' . $Img ) ) ) {
                    unlink( public_path( 'storage/category_images/' . $Img ) );
                }
            }
            $totalData++;
        }

        $jsonData = [
            'msg'     => $totalData . ' Categories Successfully Deleted!',
            'success' => true,
        ];
        return response()->json( $jsonData, 200 );
    }

    public function activeAll( $selected ) {

        $selectedId = explode( ',', $selected );
        $totalData  = 0;

        foreach ( $selectedId as $item ) {
            $update = Category::findOrFail( $item );

            if ( $update->status == '0' ) {
                $update->status = '1';
                $update->save();
                $totalData++;
            }

        }

        if ( $totalData === 0 ) {
            $jsonData = [
                'msg'     => ' Already Your Selected Category Activated!',
                'success' => true,
                'activeNumber' => 0,
            ];
            return response()->json( $jsonData, 200 );
        } else {
            $jsonData = [
                'msg'     => $totalData . ' Categories Status Successfully Activate!',
                'success' => true,
            ];
            return response()->json( $jsonData, 200 );
        }

    }
    public function inactiveAll( $selected ) {

        $selectedId = explode( ',', $selected );
        $totalData  = 0;

        foreach ( $selectedId as $item ) {
            $update = Category::findOrFail( $item );

            if ( $update->status == '1' ) {
                $update->status = '0';
                $update->save();
                $totalData++;
            }

        }

        if ( $totalData === 0 ) {
            $jsonData = [
                'msg'     => ' Already Your Selected Category Inactivated!',
                'success' => true,
                 'activeNumber' => 0,
            ];
            return response()->json( $jsonData, 200 );
        } else {
            $jsonData = [
                'msg'     => $totalData . ' Categories Status Successfully Inctivate!',
                'success' => true,
            ];
            return response()->json( $jsonData, 200 );
        }

    }
}
