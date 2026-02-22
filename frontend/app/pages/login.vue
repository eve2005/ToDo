<template>

    <div>
        <Alert v-if="mostrarModal" :mensagem="msg" :aoFechar="funcaoNavegacao" @fechar="mostrarModal = false"  />
        <div class="w-1/2 p-4 m-auto border rounded-2xl border-[#9F292C] font-paytone ">
            
            <form @submit.prevent="Logar">

                <div class="text-xl text-[#9F292C] w-full flex justify-center  "> 
                    <span class="border rounded-full border-[#9F292C] p-1 px-2">Login</span>
                </div>

                <div class="p-4 mx-3 my-2">
                    
                    <Input label="Email:" type="email" name="email" v-model="user.email"/>
                    <div class="relative">
                        <Input label="Senha:" :type="mostrarSenha ? 'text' : 'password'" name="senha" v-model="user.senha"/>
                        <button  type="button" @click="mostrarSenha = !mostrarSenha"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-xl"
                    >
                        <img v-if="mostrarSenha" :src="eye" alt="Esconder senha" class="w-6 h-6" />
                        <img v-else :src="eye_off" alt="Mostar senha" class="w-6 h-6" />
                    
                    </button>
                    </div>
                    
                
                </div>

                <div class="w-full flex justify-center "> 
                    <button class=" border rounded-full border-[#9F292C] p-2 bg-[#9F292C] text-white hover:bg-white hover:text-[#9F292C]" 
                    type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>
        
   
</template>

<script setup>
import Input from '~/components/Forms/Input.vue';
import eye from '~/assets/icon/eye.svg';
import eye_off from '~/assets/icon/eye_off.svg';
import Alert from '~/components/Modal/Alert.vue';

    const mostrarSenha = ref(false);
    const mostrarModal = ref(false);
    const msg = ref('');
    const funcaoNavegacao = ref(null);


    const token = useCookie('token', {
     maxAge: 60 * 15,
    sameSite: 'lax'});
     

    const user = ref({
        email: '',
        senha: '',
    });

    async function Logar() {
        if(!user.value.email || !user.value.senha){
            msg.value = "Preencha todos os campos";
            mostrarModal.value = true;
            return;
        }

        try{
            const resposta = await $fetch('http://localhost:8000/api/login', {
                method:'POST',
                body: user.value
            });
            
            if(resposta.status == "ok"){
                if(resposta.token)
                {
                    token.value = resposta.token;
                    localStorage.setItem('user', JSON.stringify(resposta.user));
                    msg.value = "Bem vindo " + resposta.user.nome;
                    funcaoNavegacao.value = () => {navigateTo('/dashboard', { replace: true })};
                    mostrarModal.value = true;
                    
                }
            }else if(resposta.error){
                msg.value = resposta.error;
                mostrarModal.value = true;
                //alert(resposta.error);
            }
        }catch(e){
            console.log(e);
            
        }
    }
definePageMeta({
  middleware: 'deslog'
});
</script>
