@extends('admin.shapes.add_shape')

@section('sectionTitle', 'Edit shape')
@section('formTitle', 'Edit shape or line')
@section('formId', 'editShapeForm')
@section('fileName', $file_name)
@section('filePath', $shape->image_path)
@section('editButton', 'Update')
@section('successModalTitle', 'Item edited')
@section('successModalText', 'The item has been succesfully edited.')

@section('requestType')
	{{method_field('PUT')}}
@endsection

