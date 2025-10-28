@props(['category', 'icon' => null, 'image' => null, 'description', 'bgColor' => 'from-slate-50 to-slate-100'])

<div class="group relative bg-gradient-to-br {{ $bgColor }} rounded-3xl p-6 hover:shadow-xl hover:shadow-black/10 hover:-translate-y-2 hover:scale-[1.02] transition-all duration-500 ease-out cursor-pointer flex items-center flex-shrink-0 min-w-fit max-w-xs border border-white/20 hover:border-white/50 backdrop-blur-sm overflow-hidden">
    <!-- Enhanced background pattern with animation -->
    <div class="absolute inset-0 opacity-5 transition-opacity duration-300 group-hover:opacity-10">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white rounded-full -translate-y-16 translate-x-16 transition-transform duration-500 group-hover:scale-110"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white rounded-full translate-y-12 -translate-x-12 transition-transform duration-500 group-hover:scale-110"></div>
    </div>
    
    <!-- Animated background glow -->
    <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-white/20 opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>
    
    <!-- Icon/Image Container -->
    <div class="relative flex-shrink-0 mr-4 z-10">
        <div class="w-16 h-16 flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 ease-out bg-white/30 group-hover:bg-white/40 rounded-2xl backdrop-blur-sm border border-white/40 group-hover:border-white/60 shadow-lg group-hover:shadow-xl">
            @if($image)
                <img src="{{ asset($image) }}" 
                     alt="{{ $category }}" 
                     class="w-12 h-12 object-cover rounded-xl shadow-md">
            @elseif($icon)
                <div class="text-gray-700 transition-colors duration-300 group-hover:text-gray-800">
                    {!! $icon !!}
                </div>
            @else
                <!-- Modern default icon -->
                <svg class="w-10 h-10 text-gray-600 transition-colors duration-300 group-hover:text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                    <circle cx="9" cy="9" r="2"/>
                    <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                </svg>
            @endif
        </div>
    </div>
    
    <!-- Category Info -->
    <div class="relative text-left flex-1 min-w-0 z-10">
        <h3 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-gray-900 transition-colors duration-300 truncate">{{ $category }}</h3>
        <p class="text-sm text-gray-600 leading-relaxed group-hover:text-gray-700 transition-colors duration-300 truncate">{{ $description }}</p>
    </div>
    
    <!-- Subtle shine effect on hover -->
    <div class="absolute inset-0 opacity-0 transition-opacity duration-700 group-hover:opacity-100">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-r from-transparent via-white/10 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-out"></div>
    </div>
</div>