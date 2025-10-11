@extends('layouts.app')

@section('content')
<!-- Breadcumb -->
<section class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg.jpg') }}">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">{{ $book->title }}</h1>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('ai-insights.index') }}">AI Insights</a></li>
                    <li>{{ Str::limit($book->title, 30) }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Book Details with AI Insight -->
<section class="space">
    <div class="container">
        <div class="row">
            <!-- Left Column: Book Info -->
            <div class="col-lg-4">
                <div class="book-details" style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); position: sticky; top: 100px;">
                    @if($book->image)
                    <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" class="w-100 mb-4" style="border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
                    @else
                    <div style="width: 100%; height: 400px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; margin-bottom: 25px;">
                        <i class="fas fa-book" style="font-size: 100px; color: white; opacity: 0.5;"></i>
                    </div>
                    @endif
                    
                    <h2 style="font-size: 24px; font-weight: bold; margin-bottom: 15px;">{{ $book->title }}</h2>
                    <p style="color: #666; margin-bottom: 20px;">
                        <i class="fas fa-user"></i> <strong>Auteur:</strong> {{ $book->author }}
                    </p>
                    
                    @if($book->category)
                    <p style="color: #666; margin-bottom: 20px;">
                        <i class="fas fa-tag"></i> <strong>Catégorie:</strong> {{ $book->category->name }}
                    </p>
                    @endif
                    
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-comments"></i> Total Avis:</span>
                            <strong>{{ $reviewsStats['total'] }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-brain"></i> Avec AI:</span>
                            <strong>{{ $reviewsStats['with_sentiment'] }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><i class="fas fa-star"></i> Note Moyenne:</span>
                            <strong>{{ number_format($reviewsStats['avg_rating'] ?? 0, 1) }}/5</strong>
                        </div>
                    </div>
                    
                    <a href="{{ route('shop') }}" class="vs-btn w-100 mb-3" style="text-align: center;">
                        <i class="fas fa-shopping-cart"></i> Voir la Boutique
                    </a>
                    <a href="{{ route('ai-insights.index') }}" class="vs-btn style2 w-100" style="text-align: center;">
                        <i class="fas fa-arrow-left"></i> Retour à la liste
                    </a>
                </div>
            </div>
            
            <!-- Right Column: AI Insight -->
            <div class="col-lg-8">
                @if($book->insight)
                <!-- Header AI -->
                <div class="ai-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; border-radius: 20px; color: white; margin-bottom: 30px;">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <i class="fas fa-brain" style="font-size: 50px; opacity: 0.8;"></i>
                        <div>
                            <h3 style="margin: 0; font-size: 24px; font-weight: bold;">Analyse AI Complète</h3>
                            <p style="margin: 0; opacity: 0.9; font-size: 14px;">Générée le {{ $book->insight->last_generated_at ? $book->insight->last_generated_at->format('d/m/Y à H:i') : $book->insight->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>
                    <p style="margin: 0; font-size: 16px; opacity: 0.95;">
                        Cette analyse est basée sur <strong>{{ $book->insight->total_reviews }} avis</strong> traités par notre intelligence artificielle.
                    </p>
                </div>
                
                <!-- Sentiment Distribution -->
                @if($book->insight->sentiment_distribution)
                <div class="sentiment-card" style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); margin-bottom: 30px;">
                    <h4 style="margin-bottom: 20px; font-size: 20px; font-weight: bold;">
                        <i class="fas fa-chart-pie" style="color: #667eea;"></i> Distribution des Sentiments
                    </h4>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div style="background: linear-gradient(135deg, #10b981 0%, #34d399 100%); padding: 20px; border-radius: 15px; text-align: center; color: white;">
                                <div style="font-size: 36px; font-weight: bold;">{{ $book->insight->sentiment_distribution['positive'] ?? 0 }}%</div>
                                <div style="font-size: 14px; opacity: 0.9;">POSITIF</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div style="background: linear-gradient(135deg, #6b7280 0%, #9ca3af 100%); padding: 20px; border-radius: 15px; text-align: center; color: white;">
                                <div style="font-size: 36px; font-weight: bold;">{{ $book->insight->sentiment_distribution['neutral'] ?? 0 }}%</div>
                                <div style="font-size: 14px; opacity: 0.9;">NEUTRE</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div style="background: linear-gradient(135deg, #ef4444 0%, #f87171 100%); padding: 20px; border-radius: 15px; text-align: center; color: white;">
                                <div style="font-size: 36px; font-weight: bold;">{{ $book->insight->sentiment_distribution['negative'] ?? 0 }}%</div>
                                <div style="font-size: 14px; opacity: 0.9;">NÉGATIF</div>
                            </div>
                        </div>
                    </div>
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 10px;">
                        <div class="progress" style="height: 30px; border-radius: 15px;">
                            <div class="progress-bar" style="width: {{ $book->insight->sentiment_distribution['positive'] ?? 0 }}%; background: #10b981;">{{ $book->insight->sentiment_distribution['positive'] ?? 0 }}%</div>
                            <div class="progress-bar" style="width: {{ $book->insight->sentiment_distribution['neutral'] ?? 0 }}%; background: #6b7280;">{{ $book->insight->sentiment_distribution['neutral'] ?? 0 }}%</div>
                            <div class="progress-bar" style="width: {{ $book->insight->sentiment_distribution['negative'] ?? 0 }}%; background: #ef4444;">{{ $book->insight->sentiment_distribution['negative'] ?? 0 }}%</div>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Summary -->
                <div class="summary-card" style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); margin-bottom: 30px;">
                    <h4 style="margin-bottom: 20px; font-size: 20px; font-weight: bold;">
                        <i class="fas fa-magic" style="color: #667eea;"></i> Résumé Général
                    </h4>
                    <p style="color: #444; font-size: 16px; line-height: 1.8; text-align: justify;">
                        {{ $book->insight->reviews_summary }}
                    </p>
                </div>
                
                <!-- Positive Points -->
                @if($book->insight->positive_points && count($book->insight->positive_points) > 0)
                <div class="points-card" style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); margin-bottom: 30px;">
                    <h4 style="margin-bottom: 20px; font-size: 20px; font-weight: bold;">
                        <i class="fas fa-thumbs-up" style="color: #10b981;"></i> Points Forts
                    </h4>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        @foreach($book->insight->positive_points as $point)
                        <li style="background: #f0fdf4; border-left: 4px solid #10b981; padding: 15px 20px; margin-bottom: 15px; border-radius: 8px;">
                            <i class="fas fa-check-circle" style="color: #10b981; margin-right: 10px;"></i>
                            {{ $point }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <!-- Negative Points -->
                @if($book->insight->negative_points && count($book->insight->negative_points) > 0)
                <div class="points-card" style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); margin-bottom: 30px;">
                    <h4 style="margin-bottom: 20px; font-size: 20px; font-weight: bold;">
                        <i class="fas fa-exclamation-circle" style="color: #f59e0b;"></i> Points d'Amélioration
                    </h4>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        @foreach($book->insight->negative_points as $point)
                        <li style="background: #fffbeb; border-left: 4px solid #f59e0b; padding: 15px 20px; margin-bottom: 15px; border-radius: 8px;">
                            <i class="fas fa-info-circle" style="color: #f59e0b; margin-right: 10px;"></i>
                            {{ $point }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <!-- Themes -->
                @if($book->insight->top_themes && count($book->insight->top_themes) > 0)
                <div class="themes-card" style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); margin-bottom: 30px;">
                    <h4 style="margin-bottom: 20px; font-size: 20px; font-weight: bold;">
                        <i class="fas fa-tags" style="color: #8b5cf6;"></i> Thèmes Principaux
                    </h4>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach($book->insight->top_themes as $theme)
                        <span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 10px 20px; border-radius: 20px; font-size: 14px; font-weight: 500; box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);">
                            {{ $theme }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Recent Reviews -->
                @if($book->reviews->count() > 0)
                <div class="reviews-card" style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <h4 style="margin-bottom: 20px; font-size: 20px; font-weight: bold;">
                        <i class="fas fa-comments" style="color: #667eea;"></i> Derniers Avis ({{ $book->reviews->count() }})
                    </h4>
                    @foreach($book->reviews->take(5) as $review)
                    <div style="border-bottom: 1px solid #eee; padding: 15px 0; {{ !$loop->last ? 'margin-bottom: 15px;' : '' }}">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <strong>{{ $review->user->name ?? 'Anonyme' }}</strong>
                                <div class="text-warning">
                                    @for($i = 0; $i < $review->rating; $i++)
                                    <i class="fas fa-star"></i>
                                    @endfor
                                </div>
                            </div>
                            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                        <p style="margin: 0; color: #666; font-size: 14px;">{{ Str::limit($review->comment, 150) }}</p>
                    </div>
                    @endforeach
                </div>
                @endif
                
                @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Ce livre n'a pas encore d'analyse AI générée.
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
