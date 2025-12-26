@extends('public.layouts.app')

@section('meta_title', 'Contacto | Dalmolin Inmobiliaria')
@section('meta_description', 'Contactate con nosotros para tasaciones, ventas o alquileres en Concordia.')

@section('contenido')

<section class="vender-section">
  <div class="vender-container">
    
    <div class="vender-grid">
      
      <!-- Columna Izquierda: Contenido -->
      <div class="vender-content">
        <span class="section-label">TASACIONES PROFESIONALES</span>
        
        <h2 class="vender-title">¿Pensando en Vender tu Propiedad?</h2>
        
        <p class="vender-description">
          Te ofrecemos tasación gratuita y asesoramiento profesional para que vendas tu propiedad al mejor precio del mercado.
        </p>
        
        <div class="vender-features">
          <div class="feature-item">
            <div class="feature-icon">
              <i class="fa-solid fa-check"></i>
            </div>
            <span>Tasación gratuita y sin compromiso</span>
          </div>
          
          <div class="feature-item">
            <div class="feature-icon">
              <i class="fa-solid fa-check"></i>
            </div>
            <span>Marketing digital y difusión profesional</span>
          </div>
          
          <div class="feature-item">
            <div class="feature-icon">
              <i class="fa-solid fa-check"></i>
            </div>
            <span>Acompañamiento en todo el proceso</span>
          </div>
          
          <div class="feature-item">
            <div class="feature-icon">
              <i class="fa-solid fa-check"></i>
            </div>
            <span>Asesoramiento legal y documentación</span>
          </div>
        </div>
        
        <div class="vender-actions">
          <a href="#tasacion" class="btn-vender-primary">
            Solicitar Tasación
            <i class="fa-solid fa-arrow-right"></i>
          </a>
          <a href="tel:+543456256190" class="btn-vender-secondary">
            <i class="fa-solid fa-phone"></i>
            Llamar Ahora
          </a>
        </div>
      </div>
      
      <!-- Columna Derecha: Imagen -->
      <div class="vender-image">
        <img src="img/vender-propiedad.jpg" alt="Vender tu propiedad" onerror="this.src='img/dalmolin_logo2.png'">
        
        <!-- Badge flotante opcional -->
        <div class="vender-badge">
          <div class="badge-number">+500</div>
          <div class="badge-text">Propiedades<br>Vendidas</div>
        </div>
      </div>
      
    </div>
    
  </div>
</section>

@endsection