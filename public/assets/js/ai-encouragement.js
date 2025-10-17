/**
 * AI Purchase Encouragement Modal Handler
 * Gère l'interaction avec la pop-up d'encouragement à l'achat par IA
 */

class AIEncouragementModal {
    constructor() {
        this.modal = null;
        this.currentBookId = null;
        this.isLoading = false;
        
        this.init();
    }

    init() {
        // Initialiser les éléments du DOM
        this.modal = new bootstrap.Modal(document.getElementById('aiEncouragementModal'));
        
        // Attacher les événements
        this.attachEventListeners();
    }

    attachEventListeners() {
        // Événement pour le bouton d'encouragement IA
        document.addEventListener('click', (e) => {
            if (e.target.closest('.ai-encouragement-btn')) {
                e.preventDefault();
                const button = e.target.closest('.ai-encouragement-btn');
                const bookId = button.getAttribute('data-book-id');
                this.openModal(bookId);
            }
        });

        // Événement pour le bouton CTA dans la modal
        document.getElementById('aiCallToAction').addEventListener('click', () => {
            this.handleCallToAction();
        });

        // Événement pour réessayer en cas d'erreur
        document.addEventListener('click', (e) => {
            if (e.target.closest('.ai-retry-btn')) {
                e.preventDefault();
                this.generateContent(this.currentBookId);
            }
        });
    }

    openModal(bookId) {
        if (this.isLoading) return;
        
        this.currentBookId = bookId;
        this.showLoading();
        this.modal.show();
        
        // Générer le contenu IA
        this.generateContent(bookId);
    }

    async generateContent(bookId) {
        if (this.isLoading) return;
        
        this.isLoading = true;
        this.showLoading();

        try {
            const response = await fetch('/api/purchase-encouragement', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    book_id: bookId
                })
            });

            const data = await response.json();

            if (data.success) {
                this.displayContent(data.data);
            } else {
                this.showError(data.message || 'Une erreur est survenue');
            }

        } catch (error) {
            console.error('Erreur lors de la génération du contenu IA:', error);
            this.showError('Impossible de se connecter au service IA');
        } finally {
            this.isLoading = false;
        }
    }

    displayContent(content) {
        // Masquer le loading et l'erreur
        document.getElementById('aiLoading').style.display = 'none';
        document.getElementById('aiError').style.display = 'none';
        
        // Remplir le contenu
        document.getElementById('aiHeadline').textContent = content.headline || '';
        document.getElementById('aiPersuasiveText').textContent = content.persuasive_text || '';
        document.getElementById('aiSocialProof').textContent = content.social_proof || '';
        document.getElementById('aiUrgencyMessage').textContent = content.urgency_message || '';
        
        // Remplir la liste des bénéfices
        const benefitsList = document.getElementById('aiBenefitsList');
        benefitsList.innerHTML = '';
        
        if (content.benefits && Array.isArray(content.benefits)) {
            content.benefits.forEach(benefit => {
                const li = document.createElement('li');
                li.innerHTML = `<i class="fas fa-check text-success me-2"></i>${benefit}`;
                benefitsList.appendChild(li);
            });
        }
        
        // Mettre à jour le bouton CTA
        const ctaButton = document.getElementById('aiCallToAction');
        ctaButton.innerHTML = `<i class="fas fa-shopping-cart me-2"></i>${content.call_to_action || 'Ajouter au panier'}`;
        
        // Afficher les recommandations de livres similaires
        this.displaySimilarBooks(content.similar_books);
        
        // Afficher le contenu
        document.getElementById('aiContent').style.display = 'block';
        
        // Animation d'apparition
        this.animateContent();
    }

    displaySimilarBooks(similarBooks) {
        const similarBooksSection = document.getElementById('aiSimilarBooksSection');
        const similarBooksContainer = document.getElementById('aiSimilarBooks');
        
        if (similarBooks && Array.isArray(similarBooks) && similarBooks.length > 0) {
            similarBooksContainer.innerHTML = '';
            
            similarBooks.forEach((book, index) => {
                const bookCard = document.createElement('div');
                bookCard.className = 'similar-book-card mb-3';
                bookCard.innerHTML = `
                    <div class="d-flex align-items-start">
                        <div class="book-icon me-3">
                            <i class="fas fa-book text-primary"></i>
                        </div>
                        <div class="book-info flex-grow-1">
                            <h6 class="book-title mb-1">${book.title}</h6>
                            <p class="book-author text-muted mb-1">
                                <i class="fas fa-user me-1"></i>${book.author}
                            </p>
                            <p class="book-reason text-sm mb-0">
                                <i class="fas fa-lightbulb me-1 text-warning"></i>${book.reason}
                            </p>
                        </div>
                    </div>
                `;
                
                // Animation d'apparition décalée
                bookCard.style.opacity = '0';
                bookCard.style.transform = 'translateX(-20px)';
                similarBooksContainer.appendChild(bookCard);
                
                setTimeout(() => {
                    bookCard.style.transition = 'all 0.4s ease';
                    bookCard.style.opacity = '1';
                    bookCard.style.transform = 'translateX(0)';
                }, (index + 1) * 150);
            });
            
            similarBooksSection.style.display = 'block';
        } else {
            similarBooksSection.style.display = 'none';
        }
    }

    showLoading() {
        document.getElementById('aiLoading').style.display = 'block';
        document.getElementById('aiContent').style.display = 'none';
        document.getElementById('aiError').style.display = 'none';
    }

    showError(message) {
        document.getElementById('aiLoading').style.display = 'none';
        document.getElementById('aiContent').style.display = 'none';
        
        const errorDiv = document.getElementById('aiError');
        errorDiv.innerHTML = `
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                ${message}
                <br>
                <button type="button" class="btn btn-sm btn-outline-primary mt-2 ai-retry-btn">
                    <i class="fas fa-redo me-1"></i>Réessayer
                </button>
            </div>
        `;
        errorDiv.style.display = 'block';
    }

    handleCallToAction() {
        // Fermer la modal
        this.modal.hide();
        
        // Déclencher l'ajout au panier (simuler un clic sur le bouton d'ajout au panier)
        const addToCartForm = document.querySelector('form[action*="cart/add"]');
        if (addToCartForm) {
            // Optionnel: ajouter une animation ou effet visuel
            const addToCartButton = addToCartForm.querySelector('button[type="submit"]');
            if (addToCartButton) {
                addToCartButton.classList.add('btn-pulse');
                setTimeout(() => {
                    addToCartButton.classList.remove('btn-pulse');
                }, 1000);
            }
            
            // Soumettre le formulaire
            addToCartForm.submit();
        }
    }

    animateContent() {
        const contentElements = document.querySelectorAll('#aiContent > div');
        contentElements.forEach((element, index) => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                element.style.transition = 'all 0.3s ease';
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }, index * 100);
        });
    }
}

// Initialiser quand le DOM est prêt
document.addEventListener('DOMContentLoaded', () => {
    new AIEncouragementModal();
});

// Styles CSS additionnels pour les animations
const additionalStyles = `
    .btn-pulse {
        animation: pulse 0.5s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .ai-modal {
        border-radius: 15px;
        overflow: hidden;
    }
    
    .ai-modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-bottom: none;
    }
    
    .ai-modal-title {
        font-weight: 600;
    }
    
    .ai-modal-close {
        filter: brightness(0) invert(1);
    }
    
    .ai-modal-body {
        padding: 2rem;
    }
    
    .ai-title {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    
    .ai-description {
        font-size: 1.1rem;
        line-height: 1.6;
        color: #34495e;
    }
    
    .ai-section-title {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .ai-benefits-list {
        list-style: none;
        padding: 0;
    }
    
    .ai-benefits-list li {
        padding: 0.5rem 0;
        font-size: 1rem;
        color: #34495e;
    }
    
    .social-proof-card,
    .urgency-card {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        border-left: 4px solid #28a745;
    }
    
    .urgency-card {
        border-left-color: #ffc107;
    }
    
    .ai-modal-footer {
        border-top: 1px solid #dee2e6;
        padding: 1rem 2rem;
    }
    
    .ai-cta-btn {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border-radius: 25px;
        transition: all 0.3s ease;
    }
    
    .ai-cta-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }
    
    /* Styles pour les recommandations de livres similaires */
    .ai-similar-books {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }
    
    .ai-similar-books h6 {
        font-weight: 600;
        margin-bottom: 1rem;
        color: #2c3e50;
    }
    
    .similar-book-card {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .similar-book-card:hover {
        transform: translateX(5px);
        box-shadow: 0 3px 8px rgba(0,0,0,0.15);
        border-color: #007bff;
    }
    
    .book-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border-radius: 8px;
        color: white;
        font-size: 1.2rem;
    }
    
    .book-title {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.95rem;
    }
    
    .book-author {
        font-size: 0.85rem;
        color: #6c757d;
    }
    
    .book-reason {
        font-size: 0.8rem;
        color: #495057;
        font-style: italic;
    }
    
    .text-sm {
        font-size: 0.875rem;
    }
`;

// Injecter les styles
const styleSheet = document.createElement('style');
styleSheet.textContent = additionalStyles;
document.head.appendChild(styleSheet);