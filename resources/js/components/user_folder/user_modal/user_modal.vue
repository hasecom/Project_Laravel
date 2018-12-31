<template>
  <transition name="modal" appear>
    <div class="modal modal-overlay" @click.self="$emit('close')">
      <div class="modal-window">
             <slot name="header">
          </slot>
        <div class="rounded shadow border bg-white ">
          <slot/>
         </div>
        </div>
      </div>
  </transition>
</template>

<style>
.modal {
    
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    z-index: 30;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.2);
}



.modal-enter-active, .modal-leave-active {
  transition: opacity 0.2s;

}


.modal-leave-active {
  transition: opacity 0.2s ease 0.1s;
}

.modal-enter, .modal-leave-to {
  opacity: 0;

}
</style>