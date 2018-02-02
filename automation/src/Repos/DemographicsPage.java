package Repos;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;

public class DemographicsPage extends BasePage{
	
private static String Url = "/activeRecords";
	
	public static void GoToPage(WebDriver driver) {
		BasePage.GoToPageUrl(driver, Url);
	}
	//webelement to select menu itemdemographics
	public static WebElement menuDemographics(WebDriver driver) {
		return driver.findElement(By.id("email"));
	}	
	
	//webelement for radiobuttonMale
	public static WebElement maleRadio(WebDriver driver) {
		return driver.findElement(By.id("DemoMale"));
	}
	
     //webelemnt for a radiobutton female
	public static WebElement femaleRadio(WebDriver driver) {
		return driver.findElement(By.id("DemoFemale"));
	}
	
	//weblement for name
	public static WebElement name(WebDriver driver) {
		return driver.findElement(By.id("DemoName"));
	}
	
	//weblement for Age
	public static WebElement age(WebDriver driver) {
		return driver.findElement(By.id("DemoAge"));
	}

	
	//webelement for Height	
	public static WebElement height(WebDriver driver) {
		return driver.findElement(By.id("DemoHeight"));
	}
	public static WebElement heightUnit(WebDriver driver) {
		return driver.findElement(By.id("DemoHeightUnit"));
	}
	
	//webelement for Weight
	public static WebElement weight(WebDriver driver) {
		return driver.findElement(By.id("DemoWeight"));
	}
	public static WebElement weightUnit(WebDriver driver) {
		return driver.findElement(By.id("DemoWeightUnit"));
	}
	//webelement to save 
	public static WebElement saveButton(WebDriver driver) {
		return driver.findElement(By.id("btn_save_demographics"));
	}
	
	//webelemnt to cancel
	public static WebElement cancelButton(WebDriver driver) {
		return driver.findElement(By.id("email"));
	}
	//webelement for date
		public static WebElement date(WebDriver driver) {
			return driver.findElement(By.id("DemoVisitDate"));
		}
		public static WebElement save(WebDriver driver) {
			return driver.findElement(By.id("btn_save_demographics"));
		}
		//errormessage for age
		public static WebElement ageerror(WebDriver driver) {
			return driver.findElement(By.id(""));
		}
		//errormessage for height
				public static WebElement heighterror(WebDriver driver) {
					return driver.findElement(By.id(""));
				}
				//errormessage for weight
				public static WebElement weighterror(WebDriver driver) {
					return driver.findElement(By.id(""));
				}
		//roomnumber
				public static WebElement roomnumber(WebDriver driver) {
					return driver.findElement(By.id("room_number"));
				}
				
				public static WebElement alert(WebDriver driver) {
					return driver.findElement(By.id("alert"));
				}
		
		

}
