<template>
    <div>
        <Alert v-if="mostrarModal" :mensagem="msg" :aoFechar="funcaoNavegacao" @fechar="mostrarModal = false"  />
        <div class="w-1/2 p-4  m-auto border rounded-2xl border-[#9F292C] font-paytone ">
            <form @submit.prevent="Cadastrar">

                <div class="text-xl text-[#9F292C] w-full flex justify-center "> 
                    <span class="border rounded-full border-[#9F292C] p-1 px-2">Cadastre - se</span>
                </div>

                <div class="p-4 mx-3 my-2">
                    <Input label="Nome:" type="text" name="nome" v-model="form.nome"/>
                    <Input label="Email:" type="email" name="email" v-model="form.email"/>
                    <div class="relative">
                        <Input label="Senha:" :type="mostrarSenha ? 'text' : 'password'" name="senha" v-model="form.senha"/>
                        <button  type="button" @click="mostrarSenha = !mostrarSenha" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-xl">
                            <img v-if="mostrarSenha" :src="eye" alt="Esconder senha" class="w-6 h-6" />
                            <img v-else :src="eye_off" alt="Mostar senha" class="w-6 h-6" />
                        </button>
                    </div>
                    
                    <div class="relative">
                        <Input label="Confirme a senha:" :type="mostrarSenhaC ? 'text' : 'password'" name="senhaConfirme" v-model="form.senhaConfirme"/>
                        <button  type="button" @click="mostrarSenhaC = !mostrarSenhaC" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-xl">
                            <img v-if="mostrarSenhaC" :src="eye" alt="Esconder senha" class="w-6 h-6" />
                            <img v-else :src="eye_off" alt="Mostar senha" class="w-6 h-6" />
                        </button>
                        
                    </div>
                    
                </div>

                <div class="w-full flex justify-center "> 
                    <button class=" border rounded-full border-[#9F292C] p-2 bg-[#9F292C] text-white hover:bg-white hover:text-[#9F292C]" 
                    type="submit">Cadastrar</button>
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
    const mostrarSenhaC = ref(false);

    const mostrarModal = ref(false);
    const msg = ref('');
    const funcaoNavegacao = ref(null);
    const carregando = ref(false);

    const form = ref({
        nome: '',
        email: '',
        senha: '',
        senhaConfirme: ''
    });

    const token = useCookie('token', {
        maxAge: 60 * 15,
        sameSite: 'lax'
    });

    async function Cadastrar() {
        if (carregando.value) return;

        if(!form.value.nome || !form.value.email || !form.value.senha){
            msg.value = "Por favor preencha todos os campos";
            mostrarModal.value = true;
            return;
        }

        const regexSenha = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*]).{6,}$/;
        if (!regexSenha.test(form.value.senha)){
            msg.value = "A senha deve possuir pelo menos 6 caracteres incluindo uma letra maiuscula, um caracter especial e um número";
            mostrarModal.value = true;
            return;
        }
        if(form.value.senha !== form.value.senhaConfirme)
        {
            msg.value = "as senhas não coincidem";
            mostrarModal.value = true;
            return;
        }
        

        try{
            carregando.value = true;
            const resposta = await $fetch('http://localhost:8000/api/cadastrar', {
                method:'POST',
                body: form.value
            });
            if(resposta.status == "ok")
            {
                token.value = resposta.token;
                localStorage.setItem('user', JSON.stringify(resposta.user));
                msg.value = "Usuário cadastrado, Bem vindo " + resposta.user.nome;
                funcaoNavegacao.value = () => {navigateTo('/dashboard', { replace: true });};
                mostrarModal.value = true;
                 
            }
        }catch(e){
            console.log(e)
            const mensagemErro = e.response?._data?.message || "Erro ao conectar com o servidor";

            msg.value = "Erro ao cadastrar: " + mensagemErro;
            funcaoNavegacao.value = null; 
            mostrarModal.value = true;
        }
        finally {
         
            carregando.value = false; 
        }
    }
definePageMeta({
  middleware: 'deslog'
});
</script>
