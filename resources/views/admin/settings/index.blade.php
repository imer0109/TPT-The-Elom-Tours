@extends('layouts.admin')

@section('title', 'PARAMÈTRES - THE ELOM TOURS')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Paramètres du site</h1>
        <button type="button" id="save-all-settings" class="btn-primary flex items-center">
            <i class="fas fa-save mr-2"></i> Enregistrer les modifications
        </button>
    </div>
    
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Onglets de navigation -->
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex" aria-label="Tabs">
                <button class="tab-button active" data-tab="general">
                    <i class="fas fa-cog mr-2"></i>
                    Général
                </button>
                <button class="tab-button" data-tab="company">
                    <i class="fas fa-building mr-2"></i>
                    Entreprise
                </button>
                <button class="tab-button" data-tab="seo">
                    <i class="fas fa-search mr-2"></i>
                    SEO
                </button>
                <button class="tab-button" data-tab="social">
                    <i class="fas fa-share-alt mr-2"></i>
                    Réseaux sociaux
                </button>
                <button class="tab-button" data-tab="email">
                    <i class="fas fa-envelope mr-2"></i>
                    Email
                </button>
                <button class="tab-button" data-tab="api">
                    <i class="fas fa-plug mr-2"></i>
                    API
                </button>
            </nav>
        </div>
        
        <!-- Contenu des onglets -->
        <div class="p-6">
            <!-- Onglet Général -->
            <div class="tab-content active" id="general-tab">
                <form>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="site_name" class="block text-sm font-medium text-gray-700 mb-1">Nom du site</label>
                            <input type="text" id="site_name" name="site_name" value="The Elom Tours" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        </div>
                        
                        <div>
                            <label for="site_url" class="block text-sm font-medium text-gray-700 mb-1">URL du site</label>
                            <input type="url" id="site_url" name="site_url" value="https://www.elomtours.com" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        </div>
                        
                        <div>
                            <label for="admin_email" class="block text-sm font-medium text-gray-700 mb-1">Email administrateur</label>
                            <input type="email" id="admin_email" name="admin_email" value="admin@elomtours.com" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        </div>
                        
                        <div>
                            <label for="timezone" class="block text-sm font-medium text-gray-700 mb-1">Fuseau horaire</label>
                            <select id="timezone" name="timezone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                                <option value="UTC">UTC</option>
                                <option value="Europe/Paris" selected>Europe/Paris</option>
                                <option value="Africa/Lome">Africa/Lome</option>
                                <option value="America/New_York">America/New_York</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="date_format" class="block text-sm font-medium text-gray-700 mb-1">Format de date</label>
                            <select id="date_format" name="date_format" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                                <option value="d/m/Y" selected>DD/MM/YYYY (31/12/2023)</option>
                                <option value="m/d/Y">MM/DD/YYYY (12/31/2023)</option>
                                <option value="Y-m-d">YYYY-MM-DD (2023-12-31)</option>
                                <option value="d F Y">DD Month YYYY (31 Décembre 2023)</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="currency" class="block text-sm font-medium text-gray-700 mb-1">Devise</label>
                            <select id="currency" name="currency" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                                <option value="EUR" selected>Euro (€)</option>
                                <option value="USD">Dollar américain ($)</option>
                                <option value="XOF">Franc CFA (FCFA)</option>
                                <option value="GBP">Livre sterling (£)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <label for="maintenance_mode" class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="maintenance_mode" name="maintenance_mode" value="1" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/50 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                            <span class="ml-3 text-sm font-medium text-gray-900">Mode maintenance</span>
                        </label>
                        <p class="mt-1 text-sm text-gray-500">Lorsque le mode maintenance est activé, seuls les administrateurs peuvent accéder au site.</p>
                    </div>
                </form>
            </div>
            
            <!-- Onglet Entreprise -->
            <div class="tab-content hidden" id="company-tab">
                <form>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Nom de l'entreprise</label>
                            <input type="text" id="company_name" name="company_name" value="The Elom Tours SARL" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        </div>
                        
                        <div>
                            <label for="company_address" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                            <input type="text" id="company_address" name="company_address" value="123 Avenue de la Liberté" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        </div>
                        
                        <div>
                            <label for="company_city" class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
                            <input type="text" id="company_city" name="company_city" value="Lomé" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        </div>
                        
                        <div>
                            <label for="company_country" class="block text-sm font-medium text-gray-700 mb-1">Pays</label>
                            <input type="text" id="company_country" name="company_country" value="Togo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        </div>
                        
                        <div>
                            <label for="company_phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                            <input type="text" id="company_phone" name="company_phone" value="+228 90 12 34 56" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        </div>
                        
                        <div>
                            <label for="company_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="company_email" name="company_email" value="contact@elomtours.com" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="company_description" class="block text-sm font-medium text-gray-700 mb-1">Description de l'entreprise</label>
                            <textarea id="company_description" name="company_description" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">The Elom Tours est une agence de voyages spécialisée dans les circuits touristiques au Togo et en Afrique de l'Ouest. Nous proposons des expériences authentiques et inoubliables depuis 2010.</textarea>
                        </div>
                        
                        <div>
                            <label for="company_logo" class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
                            <div class="flex items-center">
                                <img src="/assets/images/logo.png" alt="Logo actuel" class="h-12 mr-4">
                                <label class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 cursor-pointer">
                                    <span>Changer le logo</span>
                                    <input type="file" id="company_logo" name="company_logo" class="sr-only" accept="image/*">
                                </label>
                            </div>
                        </div>
                        
                        <div>
                            <label for="company_favicon" class="block text-sm font-medium text-gray-700 mb-1">Favicon</label>
                            <div class="flex items-center">
                                <img src="/assets/images/favicon.ico" alt="Favicon actuel" class="h-8 mr-4">
                                <label class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 cursor-pointer">
                                    <span>Changer le favicon</span>
                                    <input type="file" id="company_favicon" name="company_favicon" class="sr-only" accept="image/x-icon,image/png">
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Onglet SEO -->
            <div class="tab-content hidden" id="seo-tab">
                <form>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">Titre meta par défaut</label>
                            <input type="text" id="meta_title" name="meta_title" value="The Elom Tours - Découvrez le Togo authentique" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                            <p class="mt-1 text-xs text-gray-500">Recommandé: 50-60 caractères</p>
                        </div>
                        
                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Description meta par défaut</label>
                            <textarea id="meta_description" name="meta_description" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">The Elom Tours vous propose des circuits touristiques authentiques au Togo et en Afrique de l'Ouest. Découvrez des paysages magnifiques, une culture riche et des expériences inoubliables.</textarea>
                            <p class="mt-1 text-xs text-gray-500">Recommandé: 150-160 caractères</p>
                        </div>
                        
                        <div>
                            <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-1">Mots-clés meta par défaut</label>
                            <input type="text" id="meta_keywords" name="meta_keywords" value="tourisme, Togo, Afrique de l'Ouest, circuit, voyage, safari, Kpalimé, Lomé" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                            <p class="mt-1 text-xs text-gray-500">Séparez les mots-clés par des virgules</p>
                        </div>
                        
                        <div>
                            <label for="google_analytics" class="block text-sm font-medium text-gray-700 mb-1">ID Google Analytics</label>
                            <input type="text" id="google_analytics" name="google_analytics" value="UA-XXXXXXXXX-X" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        </div>
                        
                        <div>
                            <label for="robots_txt" class="block text-sm font-medium text-gray-700 mb-1">Contenu du fichier robots.txt</label>
                            <textarea id="robots_txt" name="robots_txt" rows="6" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 font-mono">User-agent: *
Allow: /
Disallow: /admin/
Disallow: /private/

Sitemap: https://www.elomtours.com/sitemap.xml</textarea>
                        </div>
                        
                        <div>
                            <label for="generate_sitemap" class="block text-sm font-medium text-gray-700 mb-1">Sitemap XML</label>
                            <button type="button" id="generate_sitemap" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                <i class="fas fa-sync-alt mr-2"></i> Générer le sitemap
                            </button>
                            <p class="mt-1 text-sm text-gray-500">Dernier sitemap généré: 15/06/2023 à 10:30</p>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Onglet Réseaux sociaux -->
            <div class="tab-content hidden" id="social-tab">
                <form>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="facebook_url" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fab fa-facebook text-blue-600 mr-2"></i> Facebook
                            </label>
                            <input type="url" id="facebook_url" name="facebook_url" value="https://www.facebook.com/elomtours" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        </div>
                        
                        <div>
                            <label for="instagram_url" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fab fa-instagram text-pink-600 mr-2"></i> Instagram
                            </label>
                            <input type="url" id="instagram_url" name="instagram_url" value="https://www.instagram.com/elomtours" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        </div>
                        
                        <div>
                            <label for="twitter_url" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fab fa-twitter text-blue-400 mr-2"></i> Twitter
                            </label>
                            <input type="url" id="twitter_url" name="twitter_url" value="https://www.twitter.com/elomtours" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        </div>
                        
                        <div>
                            <label for="youtube_url" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fab fa-youtube text-red-600 mr-2"></i> YouTube
                            </label>
                            <input type="url" id="youtube_url" name="youtube_url" value="https://www.youtube.com/elomtours" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        </div>
                        
                        <div>
                            <label for="linkedin_url" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fab fa-linkedin text-blue-700 mr-2"></i> LinkedIn
                            </label>
                            <input type="url" id="linkedin_url" name="linkedin_url" value="https://www.linkedin.com/company/elomtours" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        </div>
                        
                        <div>
                            <label for="pinterest_url" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fab fa-pinterest text-red-700 mr-2"></i> Pinterest
                            </label>
                            <input type="url" id="pinterest_url" name="pinterest_url" value="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Partage sur les réseaux sociaux</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="og_title" class="block text-sm font-medium text-gray-700 mb-1">Titre Open Graph par défaut</label>
                                <input type="text" id="og_title" name="og_title" value="The Elom Tours - Voyages authentiques au Togo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                            </div>
                            
                            <div>
                                <label for="og_description" class="block text-sm font-medium text-gray-700 mb-1">Description Open Graph par défaut</label>
                                <textarea id="og_description" name="og_description" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">Découvrez nos circuits touristiques au Togo et vivez une expérience inoubliable avec The Elom Tours.</textarea>
                            </div>
                            
                            <div>
                                <label for="og_image" class="block text-sm font-medium text-gray-700 mb-1">Image Open Graph par défaut</label>
                                <div class="flex items-center">
                                    <img src="/assets/images/og-image.jpg" alt="Image Open Graph actuelle" class="h-16 mr-4 rounded">
                                    <label class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 cursor-pointer">
                                        <span>Changer l'image</span>
                                        <input type="file" id="og_image" name="og_image" class="sr-only" accept="image/*">
                                    </label>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Taille recommandée: 1200 x 630 pixels</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Onglet Email -->
            <div class="tab-content hidden" id="email-tab">
                <form>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="mail_driver" class="block text-sm font-medium text-gray-700 mb-1">Pilote d'envoi d'emails</label>
                            <select id="mail_driver" name="mail_driver" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                                <option value="smtp" selected>SMTP</option>
                                <option value="sendmail">Sendmail</option>
                                <option value="mailgun">Mailgun</option>
                                <option value="ses">Amazon SES</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="mail_host" class="block text-sm font-medium text-gray-700 mb-1">Hôte SMTP</label>
                            <input type="text" id="mail_host" name="mail_host" value="smtp.mailtrap.io" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        </div>
                        
                        <div>
                            <label for="mail_port" class="block text-sm font-medium text-gray-700 mb-1">Port SMTP</label>
                            <input type="text" id="mail_port" name="mail_port" value="2525" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        </div>
                        
                        <div>
                            <label for="mail_encryption" class="block text-sm font-medium text-gray-700 mb-1">Chiffrement SMTP</label>
                            <select id="mail_encryption" name="mail_encryption" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                                <option value="">Aucun</option>
                                <option value="tls" selected>TLS</option>
                                <option value="ssl">SSL</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="mail_username" class="block text-sm font-medium text-gray-700 mb-1">Nom d'utilisateur SMTP</label>
                            <input type="text" id="mail_username" name="mail_username" value="123456789" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        </div>
                        
                        <div>
                            <label for="mail_password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe SMTP</label>
                            <input type="password" id="mail_password" name="mail_password" value="********" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        </div>
                        
                        <div>
                            <label for="mail_from_address" class="block text-sm font-medium text-gray-700 mb-1">Adresse d'expédition</label>
                            <input type="email" id="mail_from_address" name="mail_from_address" value="noreply@elomtours.com" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        </div>
                        
                        <div>
                            <label for="mail_from_name" class="block text-sm font-medium text-gray-700 mb-1">Nom d'expédition</label>
                            <input type="text" id="mail_from_name" name="mail_from_name" value="The Elom Tours" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <button type="button" id="test_email" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                            <i class="fas fa-paper-plane mr-2"></i> Envoyer un email de test
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Onglet API -->
            <div class="tab-content hidden" id="api-tab">
                <form>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <div class="flex justify-between items-center">
                                <label for="api_key" class="block text-sm font-medium text-gray-700">Clé API</label>
                                <button type="button" id="generate_api_key" class="text-xs text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-sync-alt mr-1"></i> Régénérer
                                </button>
                            </div>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" id="api_key" name="api_key" value="elom_api_12345678901234567890" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-l-0 border-gray-300 bg-gray-50 text-gray-500 rounded-r-lg hover:bg-gray-100">
                                    <i class="far fa-copy"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex justify-between items-center">
                                <label for="api_secret" class="block text-sm font-medium text-gray-700">Secret API</label>
                                <button type="button" id="generate_api_secret" class="text-xs text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-sync-alt mr-1"></i> Régénérer
                                </button>
                            </div>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="password" id="api_secret" name="api_secret" value="elom_secret_12345678901234567890" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-l-0 border-gray-300 bg-gray-50 text-gray-500 rounded-r-lg hover:bg-gray-100" id="toggle_api_secret">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div>
                            <label for="api_rate_limit" class="block text-sm font-medium text-gray-700 mb-1">Limite de requêtes par minute</label>
                            <input type="number" id="api_rate_limit" name="api_rate_limit" value="60" min="1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Autorisations API</label>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input id="api_read" name="api_permissions[]" type="checkbox" value="read" checked class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary">
                                    <label for="api_read" class="ml-2 text-sm font-medium text-gray-900">Lecture (GET)</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="api_write" name="api_permissions[]" type="checkbox" value="write" checked class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary">
                                    <label for="api_write" class="ml-2 text-sm font-medium text-gray-900">Écriture (POST, PUT, PATCH)</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="api_delete" name="api_permissions[]" type="checkbox" value="delete" class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary">
                                    <label for="api_delete" class="ml-2 text-sm font-medium text-gray-900">Suppression (DELETE)</label>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Ressources accessibles</label>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="flex items-center">
                                    <input id="api_circuits" name="api_resources[]" type="checkbox" value="circuits" checked class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary">
                                    <label for="api_circuits" class="ml-2 text-sm font-medium text-gray-900">Circuits</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="api_reservations" name="api_resources[]" type="checkbox" value="reservations" checked class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary">
                                    <label for="api_reservations" class="ml-2 text-sm font-medium text-gray-900">Réservations</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="api_clients" name="api_resources[]" type="checkbox" value="clients" checked class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary">
                                    <label for="api_clients" class="ml-2 text-sm font-medium text-gray-900">Clients</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="api_blog" name="api_resources[]" type="checkbox" value="blog" checked class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary">
                                    <label for="api_blog" class="ml-2 text-sm font-medium text-gray-900">Blog</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="api_gallery" name="api_resources[]" type="checkbox" value="gallery" class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary">
                                    <label for="api_gallery" class="ml-2 text-sm font-medium text-gray-900">Galerie</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="api_stats" name="api_resources[]" type="checkbox" value="stats" class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary">
                                    <label for="api_stats" class="ml-2 text-sm font-medium text-gray-900">Statistiques</label>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <a href="#" class="text-blue-600 hover:text-blue-800 flex items-center">
                                <i class="fas fa-book mr-2"></i> Consulter la documentation de l'API
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion des onglets
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                
                // Désactiver tous les onglets
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.add('hidden'));
                
                // Activer l'onglet sélectionné
                this.classList.add('active');
                document.getElementById(`${tabId}-tab`).classList.remove('hidden');
            });
        });
        
        // Afficher/masquer le secret API
        const toggleApiSecret = document.getElementById('toggle_api_secret');
        const apiSecretInput = document.getElementById('api_secret');
        
        if (toggleApiSecret && apiSecretInput) {
            toggleApiSecret.addEventListener('click', function() {
                const type = apiSecretInput.getAttribute('type') === 'password' ? 'text' : 'password';
                apiSecretInput.setAttribute('type', type);
                
                const icon = this.querySelector('i');
                if (type === 'password') {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                } else {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            });
        }
        
        // Bouton d'enregistrement global
        const saveAllButton = document.getElementById('save-all-settings');
        if (saveAllButton) {
            saveAllButton.addEventListener('click', function() {
                // Simuler l'enregistrement
                const button = this;
                const originalText = button.innerHTML;
                
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Enregistrement...';
                
                setTimeout(function() {
                    button.innerHTML = '<i class="fas fa-check mr-2"></i> Enregistré !';
                    
                    setTimeout(function() {
                        button.disabled = false;
                        button.innerHTML = originalText;
                    }, 2000);
                }, 1500);
            });
        }
    });
</script>
@endsection

@section('styles')
<style>
    /* Styles pour les onglets */
    .tab-button {
        @apply px-4 py-3 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap flex items-center;
    }
    
    .tab-button.active {
        @apply border-b-2 border-primary text-primary;
    }
</style>
@endsection