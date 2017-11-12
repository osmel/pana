<script type="text/javascript" src="<?php echo base_url(); ?>js/functions_cryptography.js"></script>
<script type="text/javascript">  
  
var Crypt = new Crypt();  // constructor  
  
/*** encrypt */  
var ciphertext = Crypt.AES.encrypt("osmel calderon", "Secret Passphrase");  
console.log(ciphertext);
// H3fAh9bppeg=xuHy8woEtOfYYI18tLM76A==BKUvKCztSNl8  
  
/*** decrypt */  
var plaintext  = Crypt.AES.decrypt(ciphertext, "Secret Passphrase");  
console.log(plaintext);  

/*** MD5 */    
var digest_md5 = Crypt.HASH.md5("message");   
// 78e731027d8fd50ed642340b7c9a63b3  

/*** SHA1 */    
var digest_sha1 = Crypt.HASH.sha1("message");   
// 6f9b9af3cd6e8b8a73c2cdced37fe9f59226e27d  

console.log(digest_sha1);    
  
/*** SHA224 */    
var digest_sha224 = Crypt.HASH.sha224("message");  
// ff51ddfabb180148583ba6ac23483acd2d049e7c4fdba6a891419320  
  
/*** SHA256 */    
var digest_sha256 = Crypt.HASH.sha256("message");  
// ab530a13e45914982b79f9b7e3fba994cfd1f3fb22f71cea1afbf02b460c6d1d  
  
/*** SHA384 */    
var digest_sha384 = Crypt.HASH.sha384("message");  
// 353eb7516a27ef92e96d1a319712d84b902eaa828819e53a8b09af7028103a9978ba8feb6161e33c3619c5da4c4666a5  
  
/*** SHA512 */    
var digest_sha512 = Crypt.HASH.sha512("message");  
// f8daf57a3347cc4d6b9d575b31fe6077e2cb487f60a96233c08cb479dbf31538cc915ec6d48bdbaa96ddc1a16db4f4f96f37276cfcb3510b8246241770d5952c  
  

</script>  






<?php die;