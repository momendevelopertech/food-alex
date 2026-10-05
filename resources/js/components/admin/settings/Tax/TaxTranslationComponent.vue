<template>
    <LoadingComponent :props="loading" />

    <div id="tax-translation-modal" class="modal">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 class="modal-title">{{ $t('label.translations') }} — {{ tax.name }}</h3>
                <button class="modal-close fa-solid fa-xmark text-xl text-slate-400 hover:text-red-500"
                    @click="close"></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="save">
                    <div class="form-row">
                        <div class="form-col-12" v-if="languages.length > 0">
                            <label class="db-field-title">{{ $t('label.language') }}</label>
                            <select v-model="selectedLanguage" class="db-field-control">
                                <option v-for="lang in languages" :key="lang.id" :value="lang.code">
                                    {{ lang.name }} ({{ lang.code }})
                                </option>
                            </select>
                        </div>

                        <div class="form-col-12" v-if="selectedLanguage && form.translations[selectedLanguage]">
                            <label class="db-field-title">
                                {{ $t('label.name') }} ({{ selectedLanguage }})
                            </label>
                            <input
                                v-model="form.translations[selectedLanguage].name"
                                :placeholder="tax.name"
                                type="text"
                                class="db-field-control"
                            />
                        </div>

                        <div class="form-col-12" v-if="languages.length === 0">
                            <p class="text-sm text-gray-500">{{ $t('label.no_language_found') }}</p>
                        </div>

                        <div class="form-col-12">
                            <div class="modal-btns">
                                <button type="button" class="modal-btn-outline modal-close" @click="close">
                                    <i class="lab lab-close"></i>
                                    <span>{{ $t('button.close') }}</span>
                                </button>
                                <button type="submit" class="db-btn py-2 text-white bg-primary" v-if="languages.length > 0">
                                    <i class="lab lab-save"></i>
                                    <span>{{ $t('button.save') }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import LoadingComponent from "../../components/LoadingComponent.vue";
import alertService from "../../../../services/alertService";
import appService from "../../../../services/appService";
import statusEnum from "../../../../enums/modules/statusEnum";

export default {
    name: "TaxTranslationComponent",
    components: { LoadingComponent },
    props: {
        tax: {
            type: Object,
            default: () => ({}),
        },
    },
    data() {
        return {
            loading: { isActive: false },
            form: { translations: {} },
            languages: [],
            selectedLanguage: null,
        };
    },
    watch: {
        tax: {
            handler() {
                this.initForm();
            },
            deep: true,
        },
    },
    mounted() {
        this.fetchLanguages();
    },
    methods: {
        fetchLanguages() {
            this.loading.isActive = true;
            this.$store.dispatch('language/lists', {
                paginate: 0,
                status: statusEnum.ACTIVE,
                order_type: 'asc',
                vuex: false,
            }).then(res => {
                this.languages = res.data.data;
                if (this.languages.length > 0) {
                    this.selectedLanguage = this.languages[0].code;
                }
                this.initForm();
                this.loading.isActive = false;
            }).catch(() => {
                this.loading.isActive = false;
            });
        },
        initForm() {
            const existing = this.tax.translations || [];
            this.languages.forEach(lang => {
                const name = existing.find(t => t.locale === lang.code && t.key === 'name');
                this.form.translations[lang.code] = {
                    name: name ? name.value : '',
                };
            });
        },
        save() {
            this.loading.isActive = true;
            this.$store.dispatch('tax/saveTranslations', {
                id: this.tax.id,
                form: this.form,
            }).then(res => {
                this.loading.isActive = false;
                alertService.success(res.data.message);
                this.close();
            }).catch(err => {
                this.loading.isActive = false;
                alertService.error(err.response?.data?.message);
            });
        },
        close() {
            appService.modalHide('#tax-translation-modal');
        },
    },
};
</script>
