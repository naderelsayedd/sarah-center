
@if(!empty($page->settings['grids']))
@foreach ($page->settings['grids'] as $grid)
@php $columns = getColumnInfo($grid['grid']); @endphp
<!-- Section start -->
@php
setGridId($grid['grid_id']);
$css = getCss();
if(!empty(getBgOverlay()))
$css = 'position:relative;'.$css;
$x_components = ['header-breadcumb','home-slider','counter','event','news-area','event-gallery'];
$container = [];
$non_container = [];
foreach ($grid['data'] as $key => $components) {
    foreach($components as $component){
        if(in_array($component['section_id'], $x_components)){
            $non_container = $grid['data'];
        }else{
            $container =  $grid['data'];
        }
    }
}

@endphp

    {!! getBgOverlay() !!}
    @if(!empty($container))
                @foreach ($container as $column => $components)
                        @foreach ($components as $component)
                        
                        @php setSectionId($component['id']); @endphp
                    
                            @if(view()->exists('themes.'.activeTheme().'.pagebuilder.' . $component['section_id'] . '.view'))
                                {!! view('themes.'.activeTheme().'.pagebuilder.'. $component['section_id']. '.view')->render() !!}
                            @endif
                        @endforeach
                @endforeach
    @endif


        @if(!empty($non_container))
                    @foreach ($non_container as $column => $components)
                            @foreach ($components as $component)
                            @php setSectionId($component['id']); @endphp
                        
                                @if(view()->exists('themes.'.activeTheme().'.pagebuilder.' . $component['section_id'] . '.view'))
                                    {!! view('themes.'.activeTheme().'.pagebuilder.'. $component['section_id']. '.view')->render() !!}
                                @endif
                            @endforeach

                    @endforeach
                @endif

     


@endforeach
@endif