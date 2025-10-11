@extends('layouts.app')

@section('title', 'All Reviews')

@push('styles')
<style>
    .review-card {
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: none;
    }
    
    .review-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }
    
    .star-rating {
        color: #ffc107;
        font-size: 1.1rem;
    }
    
    .status-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.6rem;
        border-radius: 15px;
    }
    
    .filters-section {
        background: linear-gradient(135deg, #2E4A5B 0%, #D16655 100%);
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2.5rem;
        position: relative;
        box-shadow: 0 10px 30px rgba(46, 74, 91, 0.2);
    }
    
          this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Deleting...';  .filters-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.05"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.05"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.03"/><circle cx="10" cy="50" r="0.5" fill="white" opacity="0.03"/><circle cx="90" cy="30" r="0.5" fill="white" opacity="0.03"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        border-radius: 20px;
        pointer-events: none;
    }
    
    .filter-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 12px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
    }
    
    .filter-card:hover {
        background: rgba(255, 255, 255, 1);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(46, 74, 91, 0.1);
    }
    
    .filter-card .form-label {
        color: #2E4A5B !important;
        font-weight: 600;
        font-size: 0.875rem;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .filter-card .form-control,
    .filter-card .form-select {
        border: 2px solid #E9ECEF;
        border-radius: 8px;
        padding: 0.75rem;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s ease;
        background-color: white !important;
        color: #212529 !important;
        min-height: 45px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .filter-card .form-control::placeholder {
        color: #6c757d !important;
        opacity: 0.8;
        font-weight: 400;
    }
    
    .filter-card .form-control:focus,
    .filter-card .form-select:focus {
        border-color: #D16655 !important;
        box-shadow: 0 0 0 0.2rem rgba(209, 102, 85, 0.25) !important;
        background-color: white !important;
        color: #212529 !important;
        outline: none !important;
    }
    
    .filter-card .form-select option {
        color: #212529 !important;
        background-color: white !important;
    }
    
    /* Style spécial pour les selects sur navigateurs webkit */
    .filter-card .form-select::-webkit-scrollbar {
        width: 8px;
    }
    
    .filter-card .form-select::-webkit-scrollbar-thumb {
        background-color: #D16655;
        border-radius: 4px;
    }
    
    .filter-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 12px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    
    .btn-filter-primary {
        background: linear-gradient(45deg, #D16655, #BD7579);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(209, 102, 85, 0.3);
        min-height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-filter-clear {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        font-weight: 500;
        padding: 0.75rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        min-height: 45px;
        min-width: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .filter-tag {
        background: #D16655;
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0.25rem;
        white-space: nowrap;
    }
    
    .filter-tag a {
        color: white;
        text-decoration: none;
        font-weight: bold;
        margin-left: 0.5rem;
        opacity: 0.8;
        transition: opacity 0.2s ease;
    }
    
    .filter-tag a:hover {
        opacity: 1;
        color: white;
    }
    
    .active-filters {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 12px;
        padding: 1.2rem;
        position: relative;
        z-index: 1;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .filter-tag {
        background: #D16655;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0.25rem;
    }
    
    /* Animations et transitions */
    @keyframes filterSlideIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .filters-section {
        animation: filterSlideIn 0.6s ease-out;
    }
    
    .filter-card {
        animation: filterSlideIn 0.6s ease-out;
    }
    
    .filter-card:nth-child(1) { animation-delay: 0.1s; }
    .filter-card:nth-child(2) { animation-delay: 0.2s; }
    .filter-card:nth-child(3) { animation-delay: 0.3s; }
    .filter-card:nth-child(4) { animation-delay: 0.4s; }
    .filter-card:nth-child(5) { animation-delay: 0.5s; }
    
    /* Responsive Design */
    @media (max-width: 992px) {
        .filters-section {
            padding: 2rem 1.5rem;
        }
        
        .filter-card {
            margin-bottom: 1rem;
        }
        
        .active-filters {
            margin-top: 1rem;
        }
        
        .filter-tag {
            margin: 0.2rem;
            font-size: 0.8rem;
        }
    }
    
    @media (max-width: 768px) {
        .filters-section {
            padding: 1.5rem 1rem;
            margin-bottom: 1.5rem;
        }
        
        .filter-title {
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }
        
        .filter-subtitle {
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }
        
        .filter-card .form-control,
        .filter-card .form-select {
            padding: 0.6rem;
            font-size: 0.9rem;
        }
        
        .btn-filter-primary,
        .btn-filter-clear {
            padding: 0.6rem;
            font-size: 0.9rem;
        }
        
        .active-filters {
            padding: 1rem 0.75rem;
        }
        
        .filter-tag {
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
        }
    }
    
    @media (max-width: 576px) {
        .filters-section {
            padding: 1rem 0.75rem;
        }
        
        .filter-title {
            font-size: 1.1rem;
        }
        
        .filter-subtitle {
            font-size: 0.85rem;
        }
        
        .filter-card {
            padding: 0.75rem !important;
        }
        
        .filter-card .form-control,
        .filter-card .form-select {
            padding: 0.5rem;
            font-size: 0.85rem;
        }
        
        .btn-filter-primary,
        .btn-filter-clear {
            padding: 0.5rem;
            font-size: 0.85rem;
            min-height: 40px;
        }
    }
    
    /* États de focus améliorés */
    .filter-card .form-control:focus,
    .filter-card .form-select:focus {
        outline: none;
        border-color: #D16655;
        box-shadow: 0 0 0 0.2rem rgba(209, 102, 85, 0.25);
        background-color: white;
    }
    
    /* Amélioration des badges de statut */
    .status-badge.approved {
        background: linear-gradient(45deg, #28a745, #20c997);
        color: white;
    }
    
    .status-badge.pending {
        background: linear-gradient(45deg, #ffc107, #fd7e14);
        color: white;
    }
    
    .review-meta {
        font-size: 0.9rem;
        color: #6c757d;
    }
    
    .book-info {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 10px;
        margin-bottom: 1rem;
    }
    
    /* New action badges */
    .action-badges {
        display: flex;
        gap: 0.375rem;
        align-items: center;
    }
    
    .action-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        text-decoration: none;
        border: none;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .action-view {
        background: linear-gradient(135deg, #2E4A5B 0%, #3a5a6e 100%);
        color: white;
    }
    
    .action-view:hover {
        background: linear-gradient(135deg, #1f3244 0%, #2E4A5B 100%);
        color: white;
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 15px rgba(46, 74, 91, 0.3);
    }
    
    .action-edit {
        background: linear-gradient(135deg, #D16655 0%, #e07565 100%);
        color: white;
    }
    
    .action-edit:hover {
        background: linear-gradient(135deg, #b54e3f 0%, #D16655 100%);
        color: white;
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 15px rgba(209, 102, 85, 0.3);
    }
    
    .action-delete {
        background: linear-gradient(135deg, #BD7579 0%, #d18689 100%);
        color: white;
    }
    
    .action-delete:hover {
        background: linear-gradient(135deg, #a65d61 0%, #BD7579 100%);
        color: white;
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 15px rgba(189, 117, 121, 0.3);
    }
    
    /* Animation pulse pour attirer l'attention */
    .action-badges:hover .action-badge {
        animation: pulse-gentle 1s ease-in-out infinite alternate;
    }
    
    @keyframes pulse-gentle {
        0% { box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); }
        100% { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); }
    }
    
    /* Responsive - badges plus petits sur mobile */
    @media (max-width: 576px) {
        .action-badge {
            width: 28px;
            height: 28px;
            font-size: 0.75rem;
        }
        
        .action-badges {
            gap: 0.25rem;
        }
    }
    
    /* Modal personnalisé */
    .custom-modal {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
    }
    
    .custom-modal-header {
        background: linear-gradient(135deg, #BD7579 0%, #d18689 100%);
        color: white;
        border: none;
        padding: 2rem;
    }
    
    .delete-icon {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-size: 2rem;
        animation: pulse-warning 2s ease-in-out infinite;
    }
    
    @keyframes pulse-warning {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    .custom-modal-body {
        padding: 2rem;
        background: #F8EBE5;
    }
    
    .book-title-highlight {
        background: white;
        padding: 1rem;
        border-radius: 10px;
        border-left: 4px solid #D16655;
        font-weight: 600;
        color: #2E4A5B;
    }
    
    .warning-box {
        background: rgba(189, 117, 121, 0.1);
        padding: 0.75rem;
        border-radius: 8px;
        color: #BD7579;
        border: 1px solid rgba(189, 117, 121, 0.2);
    }
    
    .custom-modal-footer {
        background: white;
        border: none;
        padding: 1.5rem 2rem;
        gap: 1rem;
    }
    
    .btn-cancel {
        background: linear-gradient(135deg, #6c757d 0%, #868e96 100%);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-cancel:hover {
        background: linear-gradient(135deg, #545b62 0%, #6c757d 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
    }
    
    .btn-delete-confirm {
        background: linear-gradient(135deg, #BD7579 0%, #d18689 100%);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-delete-confirm:hover {
        background: linear-gradient(135deg, #a65d61 0%, #BD7579 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(189, 117, 121, 0.4);
    }
    
    /* Like/Dislike Buttons Styling */
    .reaction-buttons {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .btn-reaction {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        border: 2px solid transparent;
        background: #f8f9fa;
        color: #6c757d;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
    }
    
    .btn-reaction:disabled {
        cursor: not-allowed;
        opacity: 0.5;
    }
    
    .btn-reaction i {
        font-size: 1.1rem;
        transition: transform 0.3s ease;
    }
    
    .btn-reaction .count {
        font-weight: 700;
        min-width: 20px;
        text-align: center;
    }
    
    /* Like Button */
    .btn-like {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        color: #2E4A5B;
    }
    
    .btn-like:hover:not(:disabled) {
        background: linear-gradient(135deg, #2E4A5B 0%, #3a5a6e 100%);
        color: white;
        border-color: #2E4A5B;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(46, 74, 91, 0.3);
    }
    
    .btn-like:hover:not(:disabled) i {
        transform: scale(1.2) rotate(-10deg);
    }
    
    .btn-like.active {
        background: linear-gradient(135deg, #2E4A5B 0%, #3a5a6e 100%);
        color: white;
        border-color: #2E4A5B;
        box-shadow: 0 4px 15px rgba(46, 74, 91, 0.4);
        animation: pulse-like 0.5s ease-out;
    }
    
    /* Dislike Button */
    .btn-dislike {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        color: #BD7579;
    }
    
    .btn-dislike:hover:not(:disabled) {
        background: linear-gradient(135deg, #BD7579 0%, #d18689 100%);
        color: white;
        border-color: #BD7579;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(189, 117, 121, 0.3);
    }
    
    .btn-dislike:hover:not(:disabled) i {
        transform: scale(1.2) rotate(10deg);
    }
    
    .btn-dislike.active {
        background: linear-gradient(135deg, #BD7579 0%, #d18689 100%);
        color: white;
        border-color: #BD7579;
        box-shadow: 0 4px 15px rgba(189, 117, 121, 0.4);
        animation: pulse-dislike 0.5s ease-out;
    }
    
    /* Animations */
    @keyframes pulse-like {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
    
    @keyframes pulse-dislike {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
    
    /* Effet de clic */
    .btn-reaction:active:not(:disabled) {
        transform: scale(0.95);
    }
    
    /* Reaction Stats (pour l'auteur) */
    .reaction-stat {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.8rem;
        background: #f8f9fa;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
    }
    
    .reaction-stat i {
        font-size: 1rem;
    }
    
    .reaction-score {
        font-size: 0.85rem;
        font-weight: 600;
        padding: 0.3rem 0.6rem;
        background: rgba(46, 74, 91, 0.1);
        border-radius: 15px;
    }
    
    /* Loading state */
    .btn-reaction.loading {
        pointer-events: none;
        opacity: 0.7;
    }
    
    .btn-reaction.loading i {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Responsive */
    @media (max-width: 576px) {
        .btn-reaction {
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
        }
        
        .btn-reaction i {
            font-size: 1rem;
        }
        
        .reaction-buttons {
            gap: 0.5rem;
        }
    }
    
    /* ============================================
       NEW MODALS STYLES
       ============================================ */
    
    /* Success Reaction Modal */
    .success-modal .modal-content {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
    }
    
    .success-icon-animated {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #28a745, #20c997);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        animation: successPulse 1s ease-out;
    }
    
    .success-icon-animated i {
        font-size: 2.5rem;
        color: white;
        animation: successCheckmark 0.5s ease-out 0.3s backwards;
    }
    
    @keyframes successPulse {
        0% { transform: scale(0); opacity: 0; }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); opacity: 1; }
    }
    
    @keyframes successCheckmark {
        0% { transform: scale(0) rotate(-45deg); }
        100% { transform: scale(1) rotate(0deg); }
    }
    
    /* View Reactions Modal */
    .reactions-modal .modal-content {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
    }
    
    .reactions-modal-header {
        background: linear-gradient(135deg, #2E4A5B 0%, #3a5a6e 100%);
        color: white;
        border: none;
        padding: 1.5rem;
    }
    
    .reaction-tab-like {
        background: rgba(46, 74, 91, 0.1);
        color: #2E4A5B;
        border: 2px solid transparent;
        border-radius: 25px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .reaction-tab-like:hover,
    .reaction-tab-like.active {
        background: linear-gradient(135deg, #2E4A5B 0%, #3a5a6e 100%);
        color: white;
        border-color: #2E4A5B;
    }
    
    .reaction-tab-dislike {
        background: rgba(189, 117, 121, 0.1);
        color: #BD7579;
        border: 2px solid transparent;
        border-radius: 25px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .reaction-tab-dislike:hover,
    .reaction-tab-dislike.active {
        background: linear-gradient(135deg, #BD7579 0%, #d18689 100%);
        color: white;
        border-color: #BD7579;
    }
    
    .users-list {
        max-height: 400px;
        overflow-y: auto;
    }
    
    .user-reaction-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        background: white;
        border-radius: 12px;
        margin-bottom: 0.75rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        animation: slideInFromLeft 0.4s ease-out;
    }
    
    .user-reaction-item:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    @keyframes slideInFromLeft {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    .user-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2E4A5B, #3a5a6e);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        margin-right: 1rem;
        font-size: 1.1rem;
    }
    
    .user-reaction-info {
        flex: 1;
    }
    
    .user-reaction-name {
        font-weight: 600;
        color: #2E4A5B;
        margin-bottom: 0.25rem;
    }
    
    .user-reaction-time {
        font-size: 0.85rem;
        color: #6c757d;
    }
    
    .reaction-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .reaction-badge-like {
        background: linear-gradient(135deg, #2E4A5B, #3a5a6e);
        color: white;
    }
    
    .reaction-badge-dislike {
        background: linear-gradient(135deg, #BD7579, #d18689);
        color: white;
    }
    
    /* Reaction Confirmation Modal */
    .confirm-modal .modal-content {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
    }
    
    .confirm-modal-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: none;
        padding: 2rem;
    }
    
    .reaction-icon-large {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #2E4A5B, #3a5a6e);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        animation: iconBounce 0.6s ease-out;
    }
    
    .reaction-icon-large i {
        font-size: 2.5rem;
        color: white;
    }
    
    .reaction-icon-large.dislike-icon {
        background: linear-gradient(135deg, #BD7579, #d18689);
    }
    
    @keyframes iconBounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-20px); }
        60% { transform: translateY(-10px); }
    }
    
    .review-preview {
        font-style: italic;
        line-height: 1.6;
    }
    
    /* View Reactions Button */
    .view-reactions-btn {
        border-radius: 20px;
        font-size: 0.85rem;
        padding: 0.4rem 0.8rem;
        transition: all 0.3s ease;
        border-width: 2px;
    }
    
    .view-reactions-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    /* Empty State */
    .empty-reactions {
        text-align: center;
        padding: 3rem 1rem;
        color: #6c757d;
    }
    
    .empty-reactions i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }
    
    /* Scrollbar Styling for Users List */
    .users-list::-webkit-scrollbar {
        width: 8px;
    }
    
    .users-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .users-list::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #2E4A5B, #3a5a6e);
        border-radius: 10px;
    }
    
    .users-list::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #1f3244, #2E4A5B);
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="display-5 fw-bold text-dark mb-2">All Reviews</h1>
                    <p class="text-muted">Discover what our readers think</p>
                </div>
                <a href="{{ route('reviews.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>Leave a Review
                </a>
            </div>

            <!-- Filters -->
            <div class="filters-section">
                <div class="text-center mb-4">
                    <h3 class="filter-title">
                        <i class="fas fa-filter me-2"></i>
                        Filter Reviews
                    </h3>
                    <p class="filter-subtitle">
                        Discover what our readers think
                    </p>
                </div>

                <form method="GET" action="{{ route('reviews.index') }}" id="filtersForm">
                    <div class="row g-3 align-items-end">
                        <!-- Recherche - Plus compacte -->
                        <div class="col-lg-4 col-md-12">
                            <div class="filter-card p-3 h-100">
                                <label for="search" class="form-label">
                                    <i class="fas fa-search"></i>
                                    Search
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="search" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Title, author, user...">
                            </div>
                        </div>

                        <!-- Statut - Plus compact -->
                        <div class="col-lg-2 col-md-3">
                            <div class="filter-card p-3 h-100">
                                <label for="status" class="form-label">
                                    <i class="fas fa-check-circle"></i>
                                    Status
                                </label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">All</option>
                                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>
                                        Approuvés
                                    </option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>
                                        En attente
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Note - Plus compact -->
                        <div class="col-lg-2 col-md-3">
                            <div class="filter-card p-3 h-100">
                                <label for="rating" class="form-label">
                                    <i class="fas fa-star"></i>
                                    Rating
                                </label>
                                <select class="form-select" id="rating" name="rating">
                                    <option value="">All</option>
                                    @for($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                            {{ $i }}★
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <!-- Tri - Plus compact -->
                        <div class="col-lg-2 col-md-3">
                            <div class="filter-card p-3 h-100">
                                <label for="sort_by" class="form-label">
                                    <i class="fas fa-sort"></i>
                                    Sort
                                </label>
                                <select class="form-select" id="sort_by" name="sort_by">
                                    <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>
                                        Recent
                                    </option>
                                    <option value="rating" {{ request('sort_by') === 'rating' ? 'selected' : '' }}>
                                        By Rating
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Actions - Plus compact -->
                        <div class="col-lg-2 col-md-3">
                            <div class="filter-card p-3 h-100 d-flex flex-column justify-content-end">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-filter-primary flex-fill">
                                        <i class="fas fa-search"></i>
                                        Filter
                                    </button>
                                    @if(request()->hasAny(['search', 'status', 'rating', 'sort_by']))
                                        <a href="{{ route('reviews.index') }}" 
                                           class="btn btn-filter-clear"
                                           title="Clear filters">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Active filters - New line for clarity -->
                    @if(request()->hasAny(['search', 'status', 'rating', 'sort_by']))
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="active-filters">
                                    <div class="d-flex align-items-center flex-wrap">
                                        <span class="text-white me-3">
                                            <i class="fas fa-filter"></i>
                                            <strong>Active filters:</strong>
                                        </span>
                                        
                                        @if(request('search'))
                                            <span class="filter-tag">
                                                <i class="fas fa-search"></i>
                                                "{{ Str::limit(request('search'), 20) }}"
                                                <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" 
                                                   class="text-white ms-1" title="Remove this filter">×</a>
                                            </span>
                                        @endif
                                        
                                        @if(request('status'))
                                            <span class="filter-tag">
                                                <i class="fas fa-check-circle"></i>
                                                {{ request('status') === 'approved' ? 'Approved' : 'Pending' }}
                                                <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" 
                                                   class="text-white ms-1" title="Remove this filter">×</a>
                                            </span>
                                        @endif
                                        
                                        @if(request('rating'))
                                            <span class="filter-tag">
                                                <i class="fas fa-star"></i>
                                                {{ request('rating') }} star{{ request('rating') > 1 ? 's' : '' }}
                                                <a href="{{ request()->fullUrlWithQuery(['rating' => null]) }}" 
                                                   class="text-white ms-1" title="Remove this filter">×</a>
                                            </span>
                                        @endif
                                        
                                        @if(request('sort_by') && request('sort_by') !== 'created_at')
                                            <span class="filter-tag">
                                                <i class="fas fa-sort"></i>
                                                By rating
                                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => null]) }}" 
                                                   class="text-white ms-1" title="Remove this filter">×</a>
                                            </span>
                                        @endif
                                        
                                        <a href="{{ route('reviews.index') }}" class="btn btn-sm btn-outline-light ms-auto">
                                            <i class="fas fa-times me-1"></i>
                                            Tout effacer
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Liste des avis -->
            @if($reviews->count() > 0)
                <div class="row">
                    @foreach($reviews as $review)
                        <div class="col-12 mb-4">
                            <div class="card review-card h-100">
                                <div class="card-body">
                                    <!-- En-tête de l'avis -->
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h5 class="mb-1 text-dark">{{ $review->user->name }}</h5>
                                                <div class="star-rating mb-1">
                                                    {!! $review->star_rating !!}
                                                </div>
                                                <div class="review-meta">
                                                    {{ $review->formatted_date }}
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex align-items-center gap-2">
                                            @if($review->is_approved)
                                                <span class="badge bg-success status-badge">Approuvé</span>
                                            @else
                                                <span class="badge bg-warning text-dark status-badge">En attente</span>
                                            @endif
                                            
                                            @auth
                                                @if(Auth::id() === $review->user_id)
                                                    <div class="action-badges d-flex gap-1 flex-wrap">
                                                        <a href="{{ route('reviews.show', $review) }}" 
                                                           class="action-badge action-view" 
                                                           title="View full review">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        
                                                        <a href="{{ route('reviews.edit', $review) }}" 
                                                           class="action-badge action-edit" 
                                                           title="Edit this review">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        
                                                        <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="d-inline" id="delete-form-{{ $review->id }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" 
                                                                    class="action-badge action-delete" 
                                                                    title="Delete this review"
                                                                    onclick="showDeleteModal({{ $review->id }}, '{{ $review->book->title }}')">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    </div>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>
                                    
                                    <!-- Book Information -->
                                    <div class="book-info">
                                        <div class="d-flex align-items-center">
                                            @if($review->book->cover_image)
                                                <img src="{{ $review->book->cover_image }}" 
                                                     alt="{{ $review->book->title }}" 
                                                     class="me-3" 
                                                     style="width: 60px; height: 80px; object-fit: cover; border-radius: 5px;">
                                            @endif
                                            <div>
                                                <h6 class="mb-1 text-dark">{{ $review->book->title }}</h6>
                                                <p class="mb-1 text-muted">par {{ $review->book->author }}</p>
                                                @if($review->book->category)
                                                    <div class="mb-2">
                                                        <span class="badge rounded-pill" style="background-color: {{ $review->book->category->color }}; color: white; font-size: 0.75rem;">
                                                            <i class="{{ $review->book->category->icon }} me-1"></i>
                                                            {{ $review->book->category->name }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Commentaire -->
                                    <div class="mt-3">
                                        <p class="text-dark mb-0">{{ $review->comment }}</p>
                                    </div>

                                    <!-- Like/Dislike Buttons -->
                                    <div class="mt-3 pt-3 border-top d-flex justify-content-between align-items-center">
                                        <div class="reaction-buttons d-flex gap-3" data-review-id="{{ $review->id }}">
                                            @php
                                                $likesCount = $review->reactions->where('reaction_type', 'like')->count();
                                                $dislikesCount = $review->reactions->where('reaction_type', 'dislike')->count();
                                                $userReaction = isset($userReactions[$review->id]) ? $userReactions[$review->id] : null;
                                                $isOwner = Auth::check() && Auth::id() === $review->user_id;
                                            @endphp
                                            
                                            @if(!$isOwner)
                                                <!-- Like Button -->
                                                <button type="button" 
                                                        class="btn-reaction btn-like {{ $userReaction === 'like' ? 'active' : '' }}"
                                                        onclick="handleReaction({{ $review->id }}, 'like')"
                                                        {{ !Auth::check() ? 'disabled' : '' }}
                                                        title="{{ !Auth::check() ? 'Connectez-vous pour réagir' : 'J\'aime cet avis' }}">
                                                    <i class="fas fa-thumbs-up"></i>
                                                    <span class="count">{{ $likesCount }}</span>
                                                </button>
                                                
                                                <!-- Dislike Button -->
                                                <button type="button" 
                                                        class="btn-reaction btn-dislike {{ $userReaction === 'dislike' ? 'active' : '' }}"
                                                        onclick="handleReaction({{ $review->id }}, 'dislike')"
                                                        {{ !Auth::check() ? 'disabled' : '' }}
                                                        title="{{ !Auth::check() ? 'Connectez-vous pour réagir' : 'Je n\'aime pas cet avis' }}">
                                                    <i class="fas fa-thumbs-down"></i>
                                                    <span class="count">{{ $dislikesCount }}</span>
                                                </button>
                                            @else
                                                <!-- Affichage pour l'auteur -->
                                                <div class="d-flex gap-3 text-muted">
                                                    <span class="reaction-stat">
                                                        <i class="fas fa-thumbs-up"></i>
                                                        <span class="count">{{ $likesCount }}</span>
                                                    </span>
                                                    <span class="reaction-stat">
                                                        <i class="fas fa-thumbs-down"></i>
                                                        <span class="count">{{ $dislikesCount }}</span>
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        @if(!$isOwner && $likesCount + $dislikesCount > 0)
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="reaction-score text-muted small">
                                                    <i class="fas fa-chart-line me-1"></i>
                                                    Score: {{ $likesCount - $dislikesCount }}
                                                </div>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-secondary view-reactions-btn"
                                                        onclick="viewReactions({{ $review->id }})"
                                                        title="Voir qui a réagi">
                                                    <i class="fas fa-users me-1"></i>
                                                    <small>Voir les réactions</small>
                                                </button>
                                            </div>
                                        @elseif($isOwner && $likesCount + $dislikesCount > 0)
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-info view-reactions-btn"
                                                    onclick="viewReactions({{ $review->id }})"
                                                    title="Voir qui a réagi à votre avis">
                                                <i class="fas fa-users me-1"></i>
                                                <small>{{ $likesCount + $dislikesCount }} réaction(s)</small>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $reviews->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-comment-slash fa-4x text-muted"></i>
                    </div>
                    <h3 class="text-muted">No Reviews Found</h3>
                    <p class="text-muted mb-4">There are no reviews matching your criteria yet.</p>
                    <a href="{{ route('reviews.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Leave the First Review
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Custom Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header custom-modal-header">
                <div class="w-100 text-center">
                    <div class="delete-icon mb-3">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h4 class="modal-title" id="deleteModalLabel">Confirm Deletion</h4>
                </div>
            </div>
            <div class="modal-body text-center custom-modal-body">
                <p class="mb-3">Are you sure you want to permanently delete your review for:</p>
                <div class="book-title-highlight mb-4">
                    <i class="fas fa-book me-2"></i>
                    <span id="bookTitleToDelete"></span>
                </div>
                <div class="warning-box">
                    <i class="fas fa-info-circle me-2"></i>
                    <small>This action is irreversible and will delete your review and rating.</small>
                </div>
            </div>
            <div class="modal-footer custom-modal-footer justify-content-center">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="button" class="btn btn-delete-confirm" id="confirmDeleteBtn">
                    <i class="fas fa-trash-alt me-2"></i>Delete Permanently
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Success Reaction Modal -->
<div class="modal fade" id="successReactionModal" tabindex="-1" aria-labelledby="successReactionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content success-modal">
            <div class="modal-body text-center p-4">
                <div class="success-icon-animated mb-3">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h5 class="mb-2" id="successReactionTitle">Réaction ajoutée !</h5>
                <p class="text-muted mb-0" id="successReactionMessage">Votre réaction a été enregistrée avec succès.</p>
            </div>
        </div>
    </div>
</div>

<!-- View Reactions Modal (Qui a réagi) -->
<div class="modal fade" id="viewReactionsModal" tabindex="-1" aria-labelledby="viewReactionsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content reactions-modal">
            <div class="modal-header reactions-modal-header">
                <h5 class="modal-title" id="viewReactionsModalLabel">
                    <i class="fas fa-users me-2"></i>Réactions à cet avis
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Tabs -->
                <ul class="nav nav-pills mb-3 justify-content-center" id="reactionTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active reaction-tab-like" id="likes-tab" data-bs-toggle="pill" 
                                data-bs-target="#likes-content" type="button" role="tab">
                            <i class="fas fa-thumbs-up me-2"></i>
                            <span class="likes-count-tab">0</span> Likes
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link reaction-tab-dislike" id="dislikes-tab" data-bs-toggle="pill" 
                                data-bs-target="#dislikes-content" type="button" role="tab">
                            <i class="fas fa-thumbs-down me-2"></i>
                            <span class="dislikes-count-tab">0</span> Dislikes
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="reactionTabContent">
                    <!-- Likes Tab -->
                    <div class="tab-pane fade show active" id="likes-content" role="tabpanel">
                        <div id="likesUsersList" class="users-list">
                            <div class="text-center py-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Chargement...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Dislikes Tab -->
                    <div class="tab-pane fade" id="dislikes-content" role="tabpanel">
                        <div id="dislikesUsersList" class="users-list">
                            <div class="text-center py-4">
                                <div class="spinner-border text-danger" role="status">
                                    <span class="visually-hidden">Chargement...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reaction Confirmation Modal -->
<div class="modal fade" id="reactionConfirmModal" tabindex="-1" aria-labelledby="reactionConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content confirm-modal">
            <div class="modal-header confirm-modal-header">
                <div class="w-100 text-center">
                    <div class="reaction-icon-large mb-3" id="confirmReactionIcon">
                        <i class="fas fa-thumbs-up"></i>
                    </div>
                    <h5 class="modal-title" id="reactionConfirmModalLabel">Confirmer votre réaction</h5>
                </div>
            </div>
            <div class="modal-body text-center">
                <p class="mb-3" id="confirmReactionText">Voulez-vous vraiment liker cet avis ?</p>
                <div class="review-preview p-3 bg-light rounded">
                    <small class="text-muted" id="confirmReviewPreview">Aperçu de l'avis...</small>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Annuler
                </button>
                <button type="button" class="btn btn-primary" id="confirmReactionBtn">
                    <i class="fas fa-check me-2"></i>Confirmer
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Global variables for delete modal
let currentDeleteForm = null;

// Function to show delete modal
function showDeleteModal(reviewId, bookTitle) {
    currentDeleteForm = document.getElementById('delete-form-' + reviewId);
    document.getElementById('bookTitleToDelete').textContent = bookTitle;
    
    // Ouvrir le modal
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Function to handle like/dislike reactions
async function handleReaction(reviewId, reactionType) {
    const container = document.querySelector(`[data-review-id="${reviewId}"]`);
    const likeBtn = container.querySelector('.btn-like');
    const dislikeBtn = container.querySelector('.btn-dislike');
    const currentBtn = reactionType === 'like' ? likeBtn : dislikeBtn;
    
    // Prevent multiple clicks
    if (currentBtn.classList.contains('loading')) {
        return;
    }
    
    // Add loading state
    currentBtn.classList.add('loading');
    
    try {
        const response = await fetch(`/reviews/${reviewId}/reactions`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                reaction_type: reactionType
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Update the UI based on action
            updateReactionButtons(reviewId, data.action, data.reaction_type, data.counts);
            
            // Show success modal with animation
            showSuccessModal(data.action, data.reaction_type);
            
            // Show success animation on button
            currentBtn.style.animation = 'none';
            setTimeout(() => {
                currentBtn.style.animation = '';
            }, 10);
            
        } else {
            // Show error message
            showNotification('error', data.message || 'Une erreur est survenue');
        }
        
    } catch (error) {
        console.error('Error:', error);
        showNotification('error', 'Impossible de traiter votre réaction. Veuillez réessayer.');
    } finally {
        // Remove loading state
        currentBtn.classList.remove('loading');
    }
}

// Update reaction buttons state
function updateReactionButtons(reviewId, action, reactionType, counts) {
    const container = document.querySelector(`[data-review-id="${reviewId}"]`);
    const likeBtn = container.querySelector('.btn-like');
    const dislikeBtn = container.querySelector('.btn-dislike');
    
    // Update counts
    likeBtn.querySelector('.count').textContent = counts.likes;
    dislikeBtn.querySelector('.count').textContent = counts.dislikes;
    
    // Update active states
    if (action === 'removed') {
        // Remove all active states
        likeBtn.classList.remove('active');
        dislikeBtn.classList.remove('active');
    } else {
        // Set active state based on reaction type
        if (reactionType === 'like') {
            likeBtn.classList.add('active');
            dislikeBtn.classList.remove('active');
        } else if (reactionType === 'dislike') {
            likeBtn.classList.remove('active');
            dislikeBtn.classList.add('active');
        }
    }
    
    // Update score if visible
    const scoreElement = container.closest('.card-body').querySelector('.reaction-score');
    if (scoreElement) {
        const score = counts.likes - counts.dislikes;
        scoreElement.innerHTML = `<i class="fas fa-chart-line me-1"></i>Score: ${score}`;
        
        // Hide score if no reactions
        if (counts.likes === 0 && counts.dislikes === 0) {
            scoreElement.style.display = 'none';
        } else {
            scoreElement.style.display = 'block';
        }
    }
}

// Show notification toast
function showNotification(type, message) {
    // Create toast element
    const toastHtml = `
        <div class="toast align-items-center text-white bg-${type === 'error' ? 'danger' : 'success'} border-0" 
             role="alert" aria-live="assertive" aria-atomic="true" 
             style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" 
                        data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;
    
    // Add to body
    const toastContainer = document.createElement('div');
    toastContainer.innerHTML = toastHtml;
    document.body.appendChild(toastContainer);
    
    // Initialize and show toast
    const toastElement = toastContainer.querySelector('.toast');
    const toast = new bootstrap.Toast(toastElement, { delay: 3000 });
    toast.show();
    
    // Remove after hidden
    toastElement.addEventListener('hidden.bs.toast', () => {
        toastContainer.remove();
    });
}

// Show success modal with animation
function showSuccessModal(action, reactionType) {
    const modal = new bootstrap.Modal(document.getElementById('successReactionModal'));
    const title = document.getElementById('successReactionTitle');
    const message = document.getElementById('successReactionMessage');
    
    if (action === 'created') {
        title.textContent = reactionType === 'like' ? '👍 Like ajouté !' : '👎 Dislike ajouté !';
        message.textContent = 'Votre réaction a été enregistrée avec succès.';
    } else if (action === 'updated') {
        title.textContent = 'Réaction modifiée !';
        message.textContent = reactionType === 'like' ? 
            'Vous avez changé votre avis en Like.' : 
            'Vous avez changé votre avis en Dislike.';
    } else if (action === 'removed') {
        title.textContent = 'Réaction supprimée';
        message.textContent = 'Votre réaction a été retirée.';
    }
    
    modal.show();
    
    // Auto-close after 2 seconds
    setTimeout(() => {
        modal.hide();
    }, 2000);
}

// View reactions modal - Show who liked/disliked
async function viewReactions(reviewId) {
    const modal = new bootstrap.Modal(document.getElementById('viewReactionsModal'));
    modal.show();
    
    // Reset content
    document.getElementById('likesUsersList').innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
        </div>
    `;
    
    document.getElementById('dislikesUsersList').innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-danger" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
        </div>
    `;
    
    try {
        const response = await fetch(`/reviews/${reviewId}/reactions/list`, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            displayReactions(data.reactions, data.counts);
        } else {
            showErrorInModal();
        }
    } catch (error) {
        console.error('Error fetching reactions:', error);
        showErrorInModal();
    }
}

// Display reactions in modal
function displayReactions(reactions, counts) {
    const likesContainer = document.getElementById('likesUsersList');
    const dislikesContainer = document.getElementById('dislikesUsersList');
    
    // Update counts in tabs
    document.querySelector('.likes-count-tab').textContent = counts.likes;
    document.querySelector('.dislikes-count-tab').textContent = counts.dislikes;
    
    // Filter reactions
    const likes = reactions.filter(r => r.reaction_type === 'like');
    const dislikes = reactions.filter(r => r.reaction_type === 'dislike');
    
    // Display likes
    if (likes.length === 0) {
        likesContainer.innerHTML = `
            <div class="empty-reactions">
                <i class="fas fa-thumbs-up"></i>
                <p class="mb-0">Aucun like pour le moment</p>
            </div>
        `;
    } else {
        likesContainer.innerHTML = likes.map((reaction, index) => `
            <div class="user-reaction-item" style="animation-delay: ${index * 0.1}s">
                <div class="user-avatar">
                    ${reaction.user_name.charAt(0).toUpperCase()}
                </div>
                <div class="user-reaction-info">
                    <div class="user-reaction-name">${reaction.user_name}</div>
                    <div class="user-reaction-time">${reaction.created_at}</div>
                </div>
                <span class="reaction-badge reaction-badge-like">
                    <i class="fas fa-thumbs-up me-1"></i>Like
                </span>
            </div>
        `).join('');
    }
    
    // Display dislikes
    if (dislikes.length === 0) {
        dislikesContainer.innerHTML = `
            <div class="empty-reactions">
                <i class="fas fa-thumbs-down"></i>
                <p class="mb-0">Aucun dislike pour le moment</p>
            </div>
        `;
    } else {
        dislikesContainer.innerHTML = dislikes.map((reaction, index) => `
            <div class="user-reaction-item" style="animation-delay: ${index * 0.1}s">
                <div class="user-avatar">
                    ${reaction.user_name.charAt(0).toUpperCase()}
                </div>
                <div class="user-reaction-info">
                    <div class="user-reaction-name">${reaction.user_name}</div>
                    <div class="user-reaction-time">${reaction.created_at}</div>
                </div>
                <span class="reaction-badge reaction-badge-dislike">
                    <i class="fas fa-thumbs-down me-1"></i>Dislike
                </span>
            </div>
        `).join('');
    }
}

// Show error in modal
function showErrorInModal() {
    const errorHtml = `
        <div class="empty-reactions">
            <i class="fas fa-exclamation-triangle"></i>
            <p class="mb-0">Impossible de charger les réactions</p>
        </div>
    `;
    document.getElementById('likesUsersList').innerHTML = errorHtml;
    document.getElementById('dislikesUsersList').innerHTML = errorHtml;
}


// Delete confirmation handler
document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (currentDeleteForm) {
        // Add loading effect
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Suppression en cours...';
        this.disabled = true;
        
        // Soumettre le formulaire après un petit délai pour l'effet visuel
        setTimeout(() => {
            currentDeleteForm.submit();
        }, 500);
    }
});

// Reset modal on close
document.getElementById('deleteModal').addEventListener('hidden.bs.modal', function() {
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    confirmBtn.innerHTML = '<i class="fas fa-trash-alt me-2"></i>Delete Permanently';
    confirmBtn.disabled = false;
    currentDeleteForm = null;
});

document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when filters change (avec délai pour la recherche)
    const searchInput = document.getElementById('search');
    const selectFilters = document.querySelectorAll('select[name="status"], select[name="rating"], select[name="sort_by"]');
    
    let searchTimeout;
    
    // Recherche avec délai
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                showFilterLoading();
                this.form.submit();
            }, 800);
        });
    }
    
    // Auto-submit pour les selects
    selectFilters.forEach(function(select) {
        select.addEventListener('change', function() {
            showFilterLoading();
            this.form.submit();
        });
    });
    
    // Animation de chargement
    function showFilterLoading() {
        const filterButton = document.querySelector('.btn-filter-primary');
        if (filterButton) {
            filterButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Chargement...';
            filterButton.disabled = true;
        }
    }
    
    // Animation d'apparition des cartes
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '0';
                entry.target.style.transform = 'translateY(20px)';
                entry.target.style.transition = 'all 0.6s ease';
                
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, 100);
                
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.review-card').forEach(card => {
        observer.observe(card);
    });
    
    // UX filter improvements
    const filterCards = document.querySelectorAll('.filter-card');
    filterCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Compteur de résultats en temps réel
    const resultsCount = document.querySelectorAll('.review-card').length;
    const filterTitle = document.querySelector('.filter-title');
    if (filterTitle && resultsCount > 0) {
        const badge = document.createElement('span');
        badge.className = 'badge bg-light text-dark ms-2';
        badge.textContent = resultsCount + (resultsCount > 1 ? ' reviews' : ' review');
        filterTitle.appendChild(badge);
    }
});
</script>
@endpush