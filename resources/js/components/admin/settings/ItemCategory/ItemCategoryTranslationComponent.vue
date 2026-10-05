<template>
    <LoadingComponent :props="loading" />
    <div class="db-card-header border-none flex items-center justify-between">
        <h3 class="db-card-title">{{ $t('label.translations') }}</h3>
        <button
            v-if="languages.length > 0"
            type="button"
            data-modal="#itemCategoryTranslationModal"
            class="db-btn text-white bg-primary py-2 px-3"
            @click="openForm()"
        >
            <i class="lab lab-add-circle-line"></i>
            <span>{{ $t('label.add_translation') }}</span>
        </button>
    </div>

    <div class="db-card-body">
        <!-- No languages -->
        <div v-if="languages.length === 0" class="mt-4 text-sm text-gray-500">
            {{ $t('label.no_language_found') }}
        </div>

        <template v-else>
            <!-- Overall progress -->
            <div class="mb-6">
                <div class="flex items-center justify-between mb-1">
                    <span class="db-field-title mb-0">{{ $t('label.translation_progress') }}</span>
                    <span class="text-sm font-semibold text-primary">
                        {{ completedCount }}/{{ languages.length }}
                    </span>
                </div>
                <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                    <div
                        class="h-full bg-primary rounded-full transition-all"
                        :style="{ width: overallProgress + '%' }"
                    ></div>
                </div>
            </div>

            <!-- Translations table -->
            <div>
                <label class="db-field-title">{{ $t('label.translated_languages') }}</label>
                <div class="db-table-responsive mt-2">
                    <table class="db-table stripe">
                        <thead class="db-table-head">
                            <tr class="db-table-head-tr">
                                <th class="db-table-head-th">{{ $t('label.language') }}</th>
                                <th class="db-table-head-th">{{ $t('label.name') }}</th>
                                <th class="db-table-head-th">{{ $t('label.status') }}</th>
                                <th class="db-table-head-th">{{ $t('label.action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="db-table-body">
                            <tr v-for="lang in languages" :key="lang.id" class="db-table-body-tr">
                                <td class="db-table-body-td">
                                    {{ lang.name }} ({{ lang.code }})
                                </td>
                                <td class="db-table-body-td">
                                    <span v-if="translationName(lang.code)">{{ translationName(lang.code) }}</span>
                                    <span v-else class="text-gray-400">—</span>
                                </td>
                                <td class="db-table-body-td">
                                    <span :class="statusClass(lang.code)">
                                        {{ statusLabel(lang.code) }}
                                    </span>
                                </td>
                                <td class="db-table-body-td">
                                    <button
                                        type="button"
                                        class="db-table-action edit"
                                        @click="openForm(lang.code)"
                                    >
                                        <i class="lab lab-edit-line"></i>
                                        <span class="db-tooltip">{{ $t('label.edit_translation') }}</span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </template>
    </div>

    <!-- Add / Edit translation modal -->
    <div id="itemCategoryTranslationModal" class="modal">
        <div class="modal-dialog max-w-[647px]">
            <div class="modal-header">
                <h3 class="modal-title">
                    {{ isEditing ? $t('label.edit_translation') : $t('label.add_translation') }}
                </h3>
                <button
                    class="modal-close fa-solid fa-xmark text-xl text-slate-400 hover:text-red-500"
                    @click="closeForm"
                ></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="save">
                    <div class="form-row">
                        <div class="form-col-12">
                            <label class="db-field-title">{{ $t('label.select_language') }}</label>
                            <select v-model="selectedLanguage" class="db-field-control">
                                <option :value="null" disabled>{{ $t('label.select_language') }}</option>
                                <option v-for="lang in languages" :key="lang.id" :value="lang.code">
                                    {{ lang.name }} ({{ lang.code }})
                                </option>
                            </select>
                        </div>

                        <template v-if="selectedLanguage && form.translations[selectedLanguage]">
                            <div class="form-col-12">
                                <label class="db-field-title">
                                    {{ $t('label.name') }} ({{ selectedLanguage }})
                                </label>
                                <input
                                    v-model="form.translations[selectedLanguage].name"
                                    :placeholder="itemCategory.name"
                                    type="text"
                                    class="db-field-control"
                                />
                            </div>

                            <div class="form-col-12">
                                <label class="db-field-title">
                                    {{ $t('label.description') }} ({{ selectedLanguage }})
                                </label>
                                <quill-editor
                                    v-model:value="form.translations[selectedLanguage].description"
                                    class="!h-40 textarea-border-radius"
                                />
                            </div>
                        </template>

                        <div class="form-col-12">
                            <div class="modal-btns">
                                <button type="button" class="modal-btn-outline modal-close" @click="closeForm">
                                    <i class="lab lab-close"></i>
                                    <span>{{ $t('button.close') }}</span>
                                </button>
                                <button
                                    type="submit"
                                    class="db-btn py-2 text-white bg-primary"
                                    :disabled="!selectedLanguage"
                                >
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
import { quillEditor } from 'vue3-quill';

export default {
    name: "ItemCategoryTranslationComponent",
    components: {
        LoadingComponent,
        quillEditor,
    },
    data() {
        return {
            loading: { isActive: false },
            form: { translations: {} },
            languages: [],
            selectedLanguage: null,
            isEditing: false,
        };
    },
    computed: {
        itemCategory() {
            return this.$store.getters['itemCategory/show'] || {};
        },
        completedCount() {
            return this.languages.filter(lang => this.filledCount(lang.code) === 2).length;
        },
        overallProgress() {
            if (this.languages.length === 0) return 0;
            return Math.round((this.completedCount / this.languages.length) * 100);
        },
    },
    watch: {
        'itemCategory.translations': {
            handler(translations) {
                if (translations && this.languages.length > 0) {
                    this.initForm();
                }
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
                this.initForm();
                this.loading.isActive = false;
            }).catch(() => {
                this.loading.isActive = false;
            });
        },
        initForm() {
            const existing = this.itemCategory.translations || [];
            this.languages.forEach(lang => {
                const name        = existing.find(t => t.locale === lang.code && t.key === 'name');
                const description = existing.find(t => t.locale === lang.code && t.key === 'description');
                this.form.translations[lang.code] = {
                    name:        name        ? name.value        : '',
                    description: description ? description.value : '',
                };
            });
        },
        openForm(code = null) {
            this.isEditing = !!code;
            this.selectedLanguage = code || null;
            appService.modalShow('#itemCategoryTranslationModal');
        },
        closeForm() {
            appService.modalHide('#itemCategoryTranslationModal');
            this.initForm();
        },
        hasValue(value) {
            if (!value) return false;
            return value.toString().replace(/<[^>]*>/g, '').trim().length > 0;
        },
        filledCount(code) {
            const t = this.form.translations[code];
            if (!t) return 0;
            return [t.name, t.description].filter(v => this.hasValue(v)).length;
        },
        translationName(code) {
            const t = this.form.translations[code];
            return t && this.hasValue(t.name) ? t.name : '';
        },
        statusLabel(code) {
            const filled = this.filledCount(code);
            if (filled === 2) return this.$t('label.completed');
            if (filled === 0) return this.$t('label.pending');
            return this.$t('label.partial');
        },
        statusClass(code) {
            const filled = this.filledCount(code);
            if (filled === 2) return 'db-table-badge text-green-600 bg-green-100';
            if (filled === 0) return 'db-table-badge text-red-600 bg-red-100';
            return 'db-table-badge text-yellow-600 bg-yellow-100';
        },
        save() {
            this.loading.isActive = true;
            this.$store.dispatch('itemCategory/saveTranslations', {
                id: this.$route.params.id,
                form: this.form,
            }).then(res => {
                this.loading.isActive = false;
                alertService.success(res.data.message);
                appService.modalHide('#itemCategoryTranslationModal');
                this.$store.dispatch('itemCategory/show', this.$route.params.id);
            }).catch(err => {
                this.loading.isActive = false;
                alertService.error(err.response?.data?.message);
            });
        },
    },
};
</script>
