@extends('admin.cliparts.add_clipart')

@section('formTitle', 'Edit Clip Art')
@section('formId', 'editClipartForm')
@section('fileName', $clipart->file_name)
@section('filePath', $clipart->image_path)
@section('editButton', 'Update')
@section('successModalTitle', 'Item edited')
@section('successModalText', 'The item has been succesfully edited.')

@section('requestType')
	{{method_field('PUT')}}
@endsection

