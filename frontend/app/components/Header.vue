<template>
  <div class=" p-3 bg-[#9F292C] font-paytone text-white flex justify-between items-center mb-3 ">
    <p>TO - DO</p>

    <div class="flex justify-end">
      <div v-if="logado" >
          <button class=" border rounded-full border-[#9F292C] p-2 bg-[#9F292C] text-white hover:bg-white hover:text-[#9F292C] " 
                  @click="logout">Logout</button>
      </div>
      <div v-else class="flex items-center gap-4">
        <NuxtLink  to="/login" replace class=" border rounded-full border-[#9F292C] p-2 bg-[#9F292C] text-white hover:bg-white hover:text-[#9F292C] ">
          Login
        </NuxtLink>         
        <p>|</p>
        <NuxtLink to="/cadastro" replace class=" border rounded-full border-[#9F292C] p-2 bg-[#9F292C] text-white hover:bg-white hover:text-[#9F292C] " >
          Cadastro
        </NuxtLink>
                 
        <Alert v-if="mostrarModal" :mensagem="msg" :aoFechar="funcaoNavegacao" @fechar="mostrarModal = false"  />
      </div>
    </div>

    
  </div>
</template>
<script setup>

import Alert from '~/components/Modal/Alert.vue';

  const token = useCookie('token');
  const logado = computed(() => !!token.value);

  const mostrarModal = ref(false);
  const msg = ref('');
  const funcaoNavegacao = ref(null);
  
  async function logout() {

        try{
            const resposta = await $fetch('http://localhost:8000/api/logout', {
                method:'POST',
                headers: {
                'Authorization': `Bearer ${token.value}`,
                'Accept': 'application/json'
              }
            });
            
        }catch(e){
            console.log(e)
        }finally{
          token.value = null;
          msg.value = "Desconectado";
          funcaoNavegacao.value = () => {navigateTo('/login', { replace: true })};
          mostrarModal.value = true;
          
        }
    }
</script>
