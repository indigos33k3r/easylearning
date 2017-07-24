<?php 
	$treeLevel++;
?>
@if (count($category->categoryChildren) == 0)
	<option value="{{$category->id}}" style="padding: 0 0 .1rem {{$treeLevel * 10}}px" >{{$category->name}}</option>
@else
	<option value="{{$category->id}}" style="padding: 0 0 .1rem {{$treeLevel * 10}}px" disabled>{{$category->name}}</option>
@endif

@foreach ($category->categoryChildren as $childCategory)
	@include('partials/option_category_child', ['category' => $childCategory, 'treeLevel' => $treeLevel])
@endforeach