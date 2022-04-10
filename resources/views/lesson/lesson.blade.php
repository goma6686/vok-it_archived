@extends('layouts.layout')
@section('title', 'Vok-IT VU Pamoka')
@section('head')
  <link type="text/css" rel="stylesheet" media="all" href="../../h5/dist/styles/h5p.css" />
  <script type="text/javascript" src="../../h5/dist/main.bundle.js"></script> 
  <!--<script type="text/javascript">
    //import { H5P } from ''; // ES6
      var params = new URLSearchParams(document.location.search.substring(1));
      var pamoka = params.get("pamoka");
      
       //const { H5P } = require('h5p-standalone'); //AMD
        // Globals
      const { H5P } = 'H5PStandalone';

      const el = document.getElementById('h5p-container');
      const h5pLocation = './' + pamoka;

      //const h5p = new H5P(el, h5pLocation);
      new H5P(document.getElementById('h5p-container'), h5pLocation, {
        frameJs: '../h5/dist/frame.bundle.js',
        frameCss: '../h5/dist/styles/h5p.css'
    });
  </script>-->
@endsection
@section('body')
  <div id="h5p-container"></div>
  <script type="text/javascript">
    //var params = new URLSearchParams(document.location.search.substring(1));
    //var pamoka = params.get("pamoka");

    //window.alert(pamoka);

    const {
      H5P
    } = H5PStandalone;
    new H5P(document.getElementById('h5p-container'), '../../pamokos_files/' + '{{ urldecode($lesson -> name) }}', {
      frameJs: '../../h5/dist/frame.bundle.js',
      frameCss: '../../h5/dist/styles/h5p.css'
    });
  </script>

  <!--<script type="text/javascript">
    import { H5P } from 'h5p-standalone'; // ES6
  // const { H5P } = require('h5p-standalone'); AMD
  // <script src="node_modules/h5p-standalone/dist/main.bundle.js"> // Globals
  // const { H5P } = 'H5PStandalone';

    var params = new URLSearchParams(document.location.search.substring(1));
      var pamoka = params.get("pamoka");
    

  const el = document.getElementById('h5p-container');
  //const h5pLocation = './workspace';

  const h5p = new H5P(el, 'pamokos/' + pamoka);
  </script>-->
@endsection