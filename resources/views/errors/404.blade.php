@extends('errors::illustrated-layout')

@section('title', !empty(trim($exception->getMessage())) ?: __('Not Found'))
@section('code', '404')
@section('message', !empty(trim($exception->getMessage())) ?: __('Not Found'))
